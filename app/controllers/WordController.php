<?php

class WordController extends BaseController{

    public function getDetail()
    {
        $word_id = Input::get('wid');
        return Entry::where('word_id','=',$word_id)->with('translations','phonetics','explains')->first();
    }

    public function query()
    {
        $key = Input::get('key');
        $entry = Entry::where('entry_key','=',$key)->with('word')->first();
        if(!$entry)
        {
            return null;
        }
        $prototype = $entry->word->word;
        return Entry::where('entry_key','=',$prototype)->with('translations','phonetics','explains')->first();
    }


    public function setState()
    {
        $word_id = Input::get('wid');
        $state = Input::get('state');
        $user = User::find(Auth::id());
        $user->words()->updateExistingPivot($word_id,array('state'=>$state));
    }

    public function setTag()
    {
        $word_id = Input::get('wid');
        $tag = Input::get('tag');
        $user = User::find(Auth::id());
        $user->words()->updateExistingPivot($word_id,array('tag'=>$tag));
    }

    public function setManyStates()
    {
        $state = Input::get('state');
        $words_selected = Input::get('words_selected');
        DB::table('user_word')->where('user_id','=',Auth::id())->whereIn('word_id',$words_selected)->update(array('state'=>$state));
    }
      
    public function setManyTags()
    {
        $tag = Input::get('tag');
        $words_selected = Input::get('words_selected');
        DB::table('user_word')->where('user_id','=',Auth::id())->whereIn('word_id',$words_selected)->update(array('tag'=>$tag));
    }

    public function setStep()
    {
        $word_id = Input::get('wid');
        $step = Input::get('step');
        // update step
        $user = User::find(Auth::id());
        $user->words()->updateExistingPivot($word_id,array('step'=>$step));
        // if step is over step, automatically update state and day_count
        if($step>3)
        {
            if($user->words->find($word_id)->pivot->state=='preview')
            {
                $user->words()->updateExistingPivot($word_id,array('state'=>'review'));
            }
            else if($user->words->find($word_id)->pivot->state=='review' && $user->words->find($word_id)->pivot->day_count==0)
            {
                if($user->words->find($word_id)->pivot->review_times==0)
                {
                    $user->words()->updateExistingPivot($word_id,array('review_times'=>1));
                    $user->words()->updateExistingPivot($word_id,array('day_count'=>2));
                }
                if($user->words->find($word_id)->pivot->review_times==1)
                {
                    $user->words()->updateExistingPivot($word_id,array('review_times'=>2));
                    $user->words()->updateExistingPivot($word_id,array('day_count'=>4));
                }
                if($user->words->find($word_id)->pivot->review_times==2)
                {
                    $user->words()->updateExistingPivot($word_id,array('review_times'=>3));
                    $user->words()->updateExistingPivot($word_id,array('day_count'=>7));
                }
                if($user->words->find($word_id)->pivot->review_times==3)
                {
                    $user->words()->updateExistingPivot($word_id,array('review_times'=>4));
                    $user->words()->updateExistingPivot($word_id,array('day_count'=>15));
                }
                if($user->words->find($word_id)->pivot->review_times==4)
                {
                    $user->words()->updateExistingPivot($word_id,array('review_times'=>5));
                    $user->words()->updateExistingPivot($word_id,array('day_count'=>30));
                }
                if($user->words->find($word_id)->pivot->review_times==5)
                {
                    $user->words()->updateExistingPivot($word_id,array('review_times'=>6));
                    $user->words()->updateExistingPivot($word_id,array('state'=>'end'));
                }
            }
        }
    }

    public function getBatch()
    {
        $step = Input::get('step');
        $book_id = Input::get('bid'); // need because we need sentence in book
        $batch_size = 20;

        // find out all the words chosen by user, cache them for later use
        $user = User::with(array('words'=>function($query) use($step){
            $query->where('chosen','=',true);
        }))->find(Auth::id());
        $words_chosen = $user->words;
        // get remaining words to calculate progress
        $words_count_step1 = $words_chosen->filter(function($item) {
            return $item->pivot->step==1;
        })->count();
        $words_count_step2 = $words_chosen->filter(function($item) {
            return $item->pivot->step==2;
        })->count();
        $words_count_step3 = $words_chosen->filter(function($item) {
            return $item->pivot->step==3;
        })->count();
        $remaining_cards_count = $words_count_step1*3+$words_count_step2*2+$words_count_step3*1;
        $data['remaining'] = $remaining_cards_count;
        $data['total'] = $words_chosen->count()*3;

        // check step one by one to find wanted words batch
        for($i=0;$i<3;$i++)
        {
            $batch_of_words = $words_chosen->filter(function($item) use($step){
                return $item->pivot->step==$step;
            })->slice(0,$batch_size);
            if(count($batch_of_words)) break;
            $step = $step%3+1;
        }
        // cannont find batch, over 
        if(!count($batch_of_words)) 
        {
            $data['step'] = 0;
            $data['batch'] = [];
        }
        else
        {
            $data['step'] = $step;

            // get enough wrong explains to use in multiple choices
            $random_array = array_rand(range(1,100000),$batch_size*3);
            $wrong_ex = Explain::whereIn('id',$random_array)->get(array('ex'));
            $wrong_ex_array = $wrong_ex->map(function($ex){
                return $ex->ex;
            });

            // get sentences in book
            $batch_of_words_id = $batch_of_words->map(function($item){
                return $item->id;
            })->toArray();
            $sentences = DB::table('book_word')->where('book_id','=',$book_id)->whereIn('word_id',$batch_of_words_id)->get(array('word_id','sentence'));
            foreach ($sentences as $item)
                $sentences_dic[$item->word_id] = $item->sentence;

            // cache dictionary 
            $batch_of_words_word = $batch_of_words->map(function($item){
                return $item->word;
            })->toArray();
            $words_dictionary = Entry::with('phonetics','explains')->whereIn('entry_key',$batch_of_words_word)->get();

            $data['batch'] = $batch_of_words->map(function($word) use($words_dictionary,$sentences_dic,$wrong_ex_array){
                // init
                $random_number = array_rand([0,1,2,3],1);
                $selects = ['','','',''];
                $answers = ['no','no','no','no'];

                // looking for dictionary item
                $dictionary_item = $words_dictionary->filter(function($item) use($word){
                    return $item->entry_key == $word->word;
                })->first();
                // building 4 selects item for multiple choices
                $selects[$random_number] = $dictionary_item->explains[0]->ex;
                for($i=0;$i<4;$i++)
                    if($i!=$random_number)
                        $selects[$i] = $wrong_ex_array->shift();

                $answers[$random_number] = 'yes';

                return (object) array(
                    'id'=>$word->id,
                    'word'=>$word->word,
                    'phonetics'=>$dictionary_item->phonetics,
                    'explains'=>$dictionary_item->explains,
                    'sentence'=>$sentences_dic[$word->id],
                    'tag'=>$word->pivot->tag,
                    'selects'=>$selects,
                    'answers'=>$answers,
                );
            });
        }

        return $data;
    }

    public function startLearn($type)
    {
        // handle user's preview request
        if($type=='preview')
        {
            $book_id = Input::get('bid');
            $chapter_id = Input::get('cid');

            // get user's words in preview state
            $user = User::with(array('words'=>function($query){
                $query->where('state','=','preview');
            }))->find(Auth::id());
            $preview_words_of_user = $user->words;
            $preview_words_of_user_id = $preview_words_of_user->map(function($item){
                return $item->id;
            })->toArray();


            // if cid is provided, ignore bid and only preview words in this chapter
            if($chapter_id)
            {
                $chapter = Chapter::with('words')->find($chapter_id);
                $words_in_chapter = $chapter->words;
                $words_in_chapter_id = $words_in_chapter->map(function($item){
                    return $item->id;
                })->toArray();

                $words_chosen = array_intersect($preview_words_of_user_id,$words_in_chapter_id);
            }
            // no cid provided, but there is bid
            else if($book_id)
            {
                $book = Book::with('words')->find($book_id);
                $words_in_book = $book->words;
                $words_in_book_id = $words_in_book->map(function($item){
                    return $item->id;
                })->toArray();

                $words_chosen = array_intersect($preview_words_of_user_id,$words_in_book_id);
            }
            else
                // we provided sentence, so book is needed
                return Response::make("ERROR",500);
        }

        // handle user's review request
        if($type=='review')
        {
            $book_id = Input::get('bid');

            // find out words of user need to be reviewed
            $user = User::with(array('words'=>function($query){
                $query->where('state','=','review')->where('day_count','<=','0');
            }))->find(Auth::id());
            $review_words_of_user = $user->words;
            $review_words_of_user_id = $review_words_of_user->map(function($item){
                return $item->id;
            })->toArray();
            // the user want to review words only in a specific book( specific chapter words seems not necessary)
            if($book_id)
            {
                $book = Book::with('words')->find($book_id);
                $words_in_book = $book->words;
                $words_in_book_id = $words_in_book->map(function($item){
                    return $item->id;
                })->toArray();

                $words_chosen = array_intersect($review_words_of_user_id,$words_in_book_id);
            }
            // the user want to review all the words that needs to be reviewed until today
            else
                // we provided sentence, so book is needed
                return Response::make("ERROR",500);
        }
        // reset chosen column
        DB::table('user_word')->where('user_id','=',Auth::id())->update(array('chosen'=>false));
        // mark all the words chosen
        DB::table('user_word')->where('user_id','=',Auth::id())->whereIn('word_id',$words_chosen)->update(array('chosen'=>true));

        
    }



    public function updatePreviewProgress()
    {
        $chapter_id = Input::get('cid');
        $chapter = Chapter::with('words')->find($chapter_id);
        $words_in_chapter = $chapter->words;
        $words_in_chapter_id = $words_in_chapter->map(function($item){
            return $item->id;
        })->toArray();

        $user = User::with(array('chapters','words'=>function($query){
            $query->where('state','=','preview');
        }))->find(Auth::id());
        if($user->chapters->find($chapter_id)->pivot->state=='open')
        {
            $preview_words_of_user = $user->words;
            $preview_words_in_step1_count = $preview_words_of_user->filter(function($item) use($words_in_chapter_id){
                return in_array($item->id,$words_in_chapter_id) && $item->pivot->step==1;
            })->count();
            $preview_words_in_step2_count = $preview_words_of_user->filter(function($item) use($words_in_chapter_id){
                return in_array($item->id,$words_in_chapter_id) && $item->pivot->step==2;
            })->count();
            $preview_words_in_step3_count = $preview_words_of_user->filter(function($item) use($words_in_chapter_id){
                return in_array($item->id,$words_in_chapter_id) && $item->pivot->step==3;
            })->count();
            $preview_words_in_step4_count = $preview_words_of_user->filter(function($item) use($words_in_chapter_id){
                return in_array($item->id,$words_in_chapter_id) && $item->pivot->step==4;
            })->count();
            $words_previewed_times = $preview_words_in_step2_count*1+$preview_words_in_step3_count*2+$preview_words_in_step4_count*3;
            $user->chapters()->updateExistingPivot($chapter_id,array('words_previewed_times'=>$words_previewed_times));
            $user_chapter = $user->chapters->find($chapter_id);
            $data['progress'] = 100*$words_previewed_times/$user_chapter->pivot->words_total/3;
            return $data; 
        }
        else
            return Response::make("ERROR",500);
    }


}
