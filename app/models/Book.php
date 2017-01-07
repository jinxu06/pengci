<?php

class Book extends Eloquent{

    public function chapters()
    {
        return $this->hasMany('Chapter');
    }

    public function subjects()
    {
        return $this->hasMany('Subject');
    }

    public function words()
    {
        return $this->belongsToMany('Word')->withPivot('sentence');
    }
    
    protected $hidden = array('publisher','rights','language','date','epub_location');
}
