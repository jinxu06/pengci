<?php

class Subject extends Eloquent{

    public function books()
    {
        return $this->belongsTo('Book');
    }
  
}
