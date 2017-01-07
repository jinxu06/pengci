<?php

class UserController extends BaseController {

    public function getDashboard()
    {
        $data['user'] = Auth::user();
        return View::make('user.dashboard',$data);
    }

    public function getBookshelf()
    {
        $user = User::with(array('books','chapters'=>function($query){
            $query->where('state','=','open')->orderBy('playorder');
        }))->find(Auth::id());
        $books = $user->books;
        $chapters = $user->chapters;
        $data['books'] = $books->map(function($book) use($chapters){
            $last_open_chapter = $chapters->filter(function($item) use($book){
                return $item->book->id==$book->id;
            })->last();
            $progress = $last_open_chapter?$last_open_chapter->heading:"还未开始阅读";
            return (object) array(
                'id'=>$book->id,
                'title'=>$book->title,
                'creator'=>$book->creator,
                'difficulty'=>$book->difficulty,
                'viewed'=>$book->viewed,
                'loved'=>$book->loved,
                'length'=>$book->length,
                'progress'=>$progress,
            );
        });
        
        return View::make('user.bookshelf',$data);
    }

    public function getWordbook()
    {
        $tab_display = Input::get('tab')?Input::get('tab'):"preview";
        $book_id = Input::get('bid');


        // get user's words list
        $user = User::with(array('books','chapters'=>function($query){
            $query->where('state','=','open');
        },'words'=>function($query){
            $query->where('state','<>','none')->orderBy('id','desc');
        }))->find(Auth::id());
        $words_of_user = $user->words;
        $books_of_user = $user->books;
        $open_chapters_of_user = $user->chapters;
        $data['user_books'] = $books_of_user;
        $data['user_chapters'] = $open_chapters_of_user;

        // count preview and review words of user
        $preview_words_count = $words_of_user->filter(function($word){
            return $word->pivot->state=='preview';
        })->count();
        $review_words_count = $words_of_user->filter(function($word){
            return $word->pivot->state=='review'&&$word->pivot->day_count==0;
        })->count();
        $data['preview_words_count'] = $preview_words_count;
        $data['review_words_count'] = $review_words_count;

        // if bid provided, filter those words not in it
        if($book_id)
        {
            // get words in that book
            $book = Book::with('words')->find($book_id);
            $words_in_book = $book->words;
            $words_in_book_id = $words_in_book->map(function($item){
                return $item->id;
            })->toArray();
            // filter
            $words_of_user = $words_of_user->filter(function($item) use($words_in_book_id){
                return in_array($item->id,$words_in_book_id);
            });
        }

        $words_return = $words_of_user->map(function($item){
            return (object) array(
                'id'=>$item->id,
                'word'=>$item->word,
                'state'=>$item->pivot->state,
                'tag'=>$item->pivot->tag
            );
        });
        $data['words'] = $words_return;// words list with info needed
        $data['selected_book_id'] = $book_id; // if bid provided
        $data['tab_display'] = $tab_display;  // which tab will be active

// deal with the situation which this page is linked from other to preview words inmediately
        $begin_learning = Input::get('bl');
        $data['begin_learning'] = $begin_learning; // show words learning modal when page show
        if($begin_learning)
        {
            $learning_book_id = Input::get('lb');
            $learning_chapter_id = Input::get('lc');
            $data['learning_book'] = Book::find($learning_book_id);
            $data['learning_chapter'] = Chapter::find($learning_chapter_id);
            if(!$data['learning_book'] || !$data['learning_chapter'])
            {
                Session::flash("message","无法找到您请求的书籍或章节的单词");
            }
        }

        return View::make('user.wordbook',$data);
    }

    public function downloadAll()
    {
        return "haha";
    }


}
