<?php

class SearchController extends BaseController{

    public function bookSearch()
    {
        $query = strtolower(Input::get('q'));
        $books_satisfied = Book::whereRaw("(LOWER(title) like ? OR LOWER(creator) like ?)",array("%".$query."%","%".$query."%"))->get();
        $user_id = Auth::id();
        if($user_id)
        {
            $books_of_user = User::with('books')->find($user_id)->books;
            $books_of_user_id = $books_of_user->map(function($item){
                return $item->id;
            })->toArray();
        }
        else
            $books_of_user_id = array();

        $subjects = Subject::all();
        $data['search_results'] = $books_satisfied->map(function($item) use($books_of_user_id, $subjects){

            $subjects_of_book = $subjects->filter(function($subject) use($item){
                return $subject->book_id==$item->id;
            });
            $subjects_of_book_content = $subjects_of_book->map(function($subject){
                return $subject->subject;
            })->toArray();
            $subjects_string = array_reduce($subjects_of_book_content,function($a,$b){
                return $a." ".$b;
            });

            $ownership = in_array($item->id,$books_of_user_id);
            return (object) array(
                'id'=>$item->id,
                'title'=>$item->title,
                'creator'=>$item->creator,
                'introduction'=>$item->introduction,
                'difficulty'=>$item->difficulty,
                'viewed'=>$item->viewed,
                'length'=>$item->length,
                'ownership'=>$ownership,
                'subjects'=>$subjects_string,
            );
        });
        return View::make('search',$data);
    }
}
