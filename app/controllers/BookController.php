<?php

class BookController extends BaseController{

    public function getBrief($book_id)
    {
        return Book::where('id','=',$book_id)->first(array('title','creator','viewed','loved'));
    }
    
    public function getDetail($book_id)
    {
        return Book::find($book_id)->toJson();
    }

    
    public function getBookPage($book_id)
    {
        $book = Book::with(array('chapters'=>function($query){
            $query->orderBy('playOrder');
        }))->find($book_id);

        $user = User::with(array('books'=>function($query) use($book_id){
            $query->find($book_id);
        }))->find(Auth::id());

        // check if user own the book, and is it new?
        $data['book_state'] = "not own";
        if($user)
        {
            if(!$user->books->isEmpty())
            {
                $progress = $user->books->first()->pivot->cfi_progress;
                if($progress)
                    $data['book_state'] = 'read';
                else
                {
                    $data['book_state'] = 'new';
                    $data['start_cid'] = $book->chapters()->where('display','=','main')->first()->id;
                }
            }
        }

        $subjects_of_book = $book->subjects;
        $subjects_of_book_content = $subjects_of_book->map(function($subject){
            return $subject->subject;
        })->toArray();
        $subjects_string = array_reduce($subjects_of_book_content,function($a,$b){
            return $a." ".$b;
        });
        $book->subjects = $subjects_string;
        $data['book'] = $book;

        $chapters = $book->chapters->map(function($chapter) use($user,$data){
            $state = '';
            $preview_progress = 0;
            if($data['book_state']!='not own')
            {
                $user_chapter = $user->chapters->find($chapter->id);
                $state = $user_chapter->pivot->state;
                if($state=='open')
                    $preview_progress = 100*$user_chapter->pivot->words_previewed_times/$user_chapter->pivot->words_total/3;
            }
            return (object) array(
                'id'=>$chapter->id,
                 'hyperlink'=>$chapter->hyperlink,
                 'heading'=>$chapter->heading,
                 'length'=>$chapter->length,
                 'state'=>$state,
                 'progress'=>$preview_progress,
             );
        });
        $data['chapters'] = $chapters;
        return View::make('bookpage',$data);
    }

    public function addToBookshelf()
    {
        $book_id = Input::get('bid');

        $user = User::with('books')->find(Auth::id());
        // prevent multiple adding
        if(!$user->books->contains($book_id))
        {
            // add chapters in book to chapter_user relationship
            $book = Book::with(array('chapters'=>function($query){
                $query->orderBy('playorder');
            }))->find($book_id);
            // cache all the chapters
            $chapters = $book->chapters;
            // now you are sure this book exists, so add it
            $user->books()->attach($book_id);
            // add viewed
            $book->viewed = $book->viewed+1;
            $book->save();
              // free all the non-main chapters
            $chapters_not_as_main = $chapters->filter(function($item){
                return $item->display!='main';
            });
            $chapters_not_as_main_id_state = [];
            $chapters_not_as_main->each(function($item) use(&$chapters_not_as_main_id_state){
                $chapters_not_as_main_id_state[$item->id] = ['state'=>'free'];
            });
            if(count($chapters_not_as_main_id_state))
                $user->chapters()->attach($chapters_not_as_main_id_state);
              // lock all the main chapters
            $chapters_as_main = $chapters->filter(function($item){
                return $item->display=='main';
            });
            $chapters_as_main_id = $chapters_as_main->map(function($item){
                return $item->id;
            })->toArray();

            if(count($chapters_as_main_id))
            {
                $user->chapters()->attach($chapters_as_main_id);
              // unlock the first main chapter
                $first_main_chapter_id = $chapters_as_main->first()->id;
                $user->chapters()->updateExistingPivot($first_main_chapter_id,array('state'=>'new'));
            }
         
        }
    }

    public function readBook()
    {
        $book_id = Input::get('bid');
        $chapter_id = Input::get('cid');
        $user = User::with('books')->find(Auth::id());

        if($chapter_id && $user->chapters->find($chapter_id)->pivot->state=='new')
            return Redirect::to('/routine/pick?cid='.$chapter_id);

        $book = Book::with(array('chapters'=>function($query){
            $query->orderBy('playOrder');
        }))->find($book_id);
        $chapters = $book->chapters;
        $data['book'] = $book;
        $data['chapters'] = $chapters;
        $data['book_id'] = $book_id;
        $data['chapter_display'] = "";
        $data['cfi'] = "";

        $data['bookmarks'] = DB::table('bookmarks')->where('user_id','=',Auth::id())->where('book_id','=',$book_id)->get();
        


        if($chapter_id)
        {
            $data['chapter_display'] = Chapter::find($chapter_id)->hyperlink;
        }
        else
        {
            $cfi = $user->books->find($book_id)->pivot->cfi_progress;
            if($cfi)
            {
                $data['cfi'] = $cfi;
            }
            else
            {
                $chapter_id = $chapters->first()->id;
                $data['chapter_display'] = Chapter::find($chapter_id)->hyperlink;
            }
        }
        return View::make('reading',$data);
    }

    public function addBookmark()
    {
        $cfi = Input::get('cfi');
        $book_id = Input::get('bid');
        $name = Input::get('n');

        $bookmark = new Bookmark;
        $bookmark->user_id = Auth::id();
        $bookmark->book_id = $book_id;
        $bookmark->bookmark = $cfi;
        $bookmark->name = $name;

        $bookmark->save();
    }

    public function updateProgress()
    {
        $cfi = Input::get('cfi');
        $book_id = Input::get('bid');

        User::find(Auth::id())->books()->updateExistingPivot($book_id,array('cfi_progress'=>$cfi));
    }
    
    public function getBookmarks()
    {
        $book_id = Input::get('bid');
        $bookmarks = DB::table('bookmarks')->where('user_id','=',Auth::id())->where('book_id','=',$book_id)->get();

        $data['bookmarks'] = $bookmarks;
        return $data;
    }

}
