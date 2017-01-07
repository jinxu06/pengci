<?php

class RoutineController extends BaseController{

    public function getPick()
    {
        $chapter_id = Input::get('cid');
        $chapter = Chapter::with('book')->find($chapter_id);
        $book = $chapter->book;


        // find out words already in user's wordbook
        $user = User::with(array('words'=>function($query) 
        {
            $query->where('state','<>','none');
        }))->find(Auth::id());
        $words_of_user = $user->words;
        $words_of_user_id = $words_of_user->map(function($item)
        {
            return $item->id;
        })->toArray();
        // get hard words appear in this chapter considered user's level
        $chapter = Chapter::with(array('words'=>function($query) use($user)
        {
            $query->where('score','>=',$user->level);
        }))->find($chapter_id);
        $words_in_chapter = $chapter->words;

        // filter those words already in user's wordbook
        $words_in_chapter_unknown = $words_in_chapter->filter(function($item) use($words_of_user_id)
        {
            if(!in_array($item->id,$words_of_user_id)) return true;
        });

        $data['book'] = $book;
        $data['chapter'] = $chapter;
        $data['words'] = $words_in_chapter_unknown;
        return View::make('routine.pick',$data);
    }

    public function postPick()
    {
        $words_selected = Input::get('words_selected');
        $chapter_id = Input::get('cid');
        // get chapters in the same book
        $book_id = Chapter::find($chapter_id)->book->id;
        $chapters_in_book = Book::find($book_id)->chapters;
        $chapters_in_book_id = $chapters_in_book->map(function($item){
            return $item->id;
        })->toArray();
        // get all the chapters of user
        $user = User::with(array('chapters'=>function($query){
            $query->orderBy('playorder');
        }))->find(Auth::id());
        $chapters_of_user = $user->chapters;
        // filter out chapters of user in the same book
        $chapters = $chapters_of_user->filter(function($item) use($chapters_in_book_id){
            return in_array($item->id,$chapters_in_book_id);
        });
        $chapter_state = $chapters->find($chapter_id)->pivot->state;
        if($chapter_state=='new')
        // default state is preview!
            // sync(*,false) should be used here, for user can post several times, but sync is too slow, so we allow multiple post
            // unique key used?
            User::with('words')->find(Auth::id())->words()->attach($words_selected);
            $user->chapters()->updateExistingPivot($chapter_id,array('state'=>'open','words_total'=>count($words_selected)));
            $chapters_locked = $chapters->filter(function($item){
                return $item->pivot->state=='lock';
            });
            if($chapters_locked->count())
            {
                $first_lock_chapter_id = $chapters_locked->first()->id;
                $user->chapters()->updateExistingPivot($first_lock_chapter_id,array('state'=>'new'));
            }
        else
            return "ERROR";

        return Redirect::route('preview')->with('words_count',count($words_selected))->with('book_id',$book_id)->with('chapter_id',$chapter_id);
    }

    public function getPreview()
    {
        return View::make('routine.preview');
    }

    public function postPreview()
    {
    }
}
