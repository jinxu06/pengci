<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersWordsRelations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('user_word',function($table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('word_id')->unsigned();
            $table->foreign('word_id')->references('id')->on('words');
            $table->enum('state',array('none','preview','discard','review','end'))->default('preview');
            $table->tinyInteger('step')->default(1);
            $table->smallInteger('day_count')->default(1);
            $table->tinyInteger('review_times')->default(0);
            $table->enum('tag',array('easy','normal','rare'))->default('normal');
            $table->boolean('chosen')->default(false);
            $table->boolean('lock')->default(false);
            $table->timestamps();
        });    
        
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('user_word');
	}

}
