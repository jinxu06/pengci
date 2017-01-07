<?php 

class Chapter extends Eloquent{

    public function book()
    {
        return $this->belongsTo('Book');
    }

    public function words()
    {
        return $this->belongsToMany('Word');
    }

}
