<?php

class Entry extends Eloquent{

    public $table = 'entries';
 
    public function translations()
    {
        return $this->hasMany('Translation','entry_id');
    }

    public function phonetics()
    {
        return $this->hasMany('Phonetic','entry_id');
    } 
    
    public function explains()
    {
        return $this->hasMany('Explain','entry_id');
    } 

    public function word()
    {
        return $this->belongsTo('Word','word_id');
    }

    protected $visible = array('id','entry_key','word','translations','phonetics','explains');
}
