<?php

class RecommendationController extends BaseController{

    public function getIndex()
    {
        $amount = 7;
        $books = Book::orderBy('viewed','desc')->get();
        $data['popular'] = $books->slice(0,$amount);
        $data['famous'] = $books->filter(function($book){
            return in_array($book->id,array(3,4,5,6,7,8,9));
        });
        $data['latest'] = $books->sort(function($a,$b){
            return $a->id<$b->id?1:-1;
        })->slice(0,$amount);
        $data['easy'] = $books->sort(function($a,$b){
            return $a->difficulty>$b->difficulty?1:-1;
        })->slice(0,$amount);
        $data['short'] = $books->sort(function($a,$b){
            return $a->length>$b->length?1:-1;
        })->slice(0,$amount);
        $data['hard'] = $books->sort(function($a,$b){
            return $a->difficulty<$b->difficulty?1:-1;
        })->slice(0,$amount);
        return View::make('index',$data);
    }

    public function getRecommendation($category)
    {
        if($category=='popular')
        {
            $books = Book::orderBy('viewed','desc')->get();
        }
        else if($category=='famous')
        {
            $books = Book::orderBy('viewed','desc')->get();
        }
        else if($category=='latest')
        {
            $books = Book::orderBy('id','desc')->get();
        }
        else if($category=='easy')
        {
            $books = Book::orderBy('difficulty')->get();
        }
        else if($category=='short')
        {
            $books = Book::orderBy('length')->get();
        }
        else if($category=='hard')
        {
            $books = Book::orderBy('difficulty','desc')->get();
        }
        else
            return "无法找到该页面";

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
        $data['books'] = $books->map(function($item) use($books_of_user_id,$subjects){
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

        return View::make('recommend',$data);

    }
}
