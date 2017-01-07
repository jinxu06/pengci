<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

    public function getReminderEmail()
    {
        return $this->email;
    }

    public function words()
    {
        return $this->belongsToMany('Word')->withPivot('state','step','tag','day_count','review_times','chosen');
    }

    public function books()
    {
        return $this->belongsToMany('Book')->withPivot('cfi_progress');
    }
   
    public function chapters()
    {
        return $this->belongsToMany('Chapter')->withPivot('state','words_total','words_previewed_times');
    }
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

    protected $fillable = array("email","username","password","confirmation_code");

}
