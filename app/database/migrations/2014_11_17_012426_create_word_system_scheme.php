<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordSystemScheme extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
       /* Schema::create('words',function($table){
            $table->increments('id');
            $table->string('word',60)->unique()->index();
            $table->tinyInteger('collins_level')->nullable();
            $table->float('exam_score')->nullable();
            //how many times this word appear in examination word list
            $table->tinyInteger('exam_count')->nullable();
            $table->tinyInteger('youdao_level')->nullable();
            //final evaluation use the information above
            $table->tinyInteger('score')->nullable();
            $table->timestamps();
       });

	    Schema::create('entries',function($table){
            $table->increments('id');
            $table->string('entry_key',60)->unique()->index();
            $table->mediumInteger('rank')->nullable();
            $table->integer('word_id')->unsigned()->nullable();
            $table->foreign('word_id')->references('id')->on('words');
            $table->timestamps();
        });    
	    Schema::create('translations',function($table){
            $table->increments('id');
            $table->string('translation',255);
            $table->integer('entry_id')->unsigned();
            $table->foreign('entry_id')->references('id')->on('entries');
            $table->timestamps();
        });    
	    Schema::create('phonetics',function($table){
            $table->increments('id');
            $table->string('uk_phonetic',255)->nullable();
            $table->string('us_phonetic',255)->nullable();
            $table->integer('entry_id')->unsigned();
            $table->foreign('entry_id')->references('id')->on('entries');
            $table->timestamps();
        });    
	    Schema::create('explains',function($table){
            $table->increments('id');
            $table->string('pos',10)->nullable();
            $table->string('ex',255);
            $table->string('lemma',60)->nullable();
            $table->integer('entry_id')->unsigned();
            $table->foreign('entry_id')->references('id')->on('entries');
            $table->timestamps();
        });*/    

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	   /* Schema::drop('explains');	
	    Schema::drop('phonetics');	
	    Schema::drop('translations');	
	    Schema::drop('entries');	
        Schema::drop('words');*/	
	}

}
