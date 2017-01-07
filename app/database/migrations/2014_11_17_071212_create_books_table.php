<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        /*
	    Schema::create('books',function($table){
            $table->increments('id');
            $table->string('title',255)->nullable();
            $table->string('creator',255)->nullable();
            $table->string('publisher',255)->nullable();
            $table->string('rights',255)->nullable();
            $table->string('language',10)->nullable();
            $table->string('date',255)->nullable();
            $table->string('epub_location',255)->nullable();
            $table->integer('difficulty')->nullable();
            $table->integer('viewed')->default(0);
            $table->integer('loved')->default(0);
            $table->integer('length')->nullable();
            $table->text('introduction')->nullable();
            $table->binary('cover')->nullable();
            $table->timestamps();
        });    
        Schema::create('chapters',function($table){
            $table->increments('id');
            $table->mediumInteger('playorder')->nullable();
            $table->string('heading',255)->nullable();
            $table->string('hyperlink',255)->nullable();
            $table->integer('length')->nullable();
            $table->enum('display',array("none","main","chapter","preface","intro"))->default("main");
            $table->integer('book_id')->unsigned()->nullable();
            $table->foreign('book_id')->references('id')->on('books');
            $table->timestamps();
        });
        Schema::create('subjects',function($table){
            $table->increments('id');
            $table->string('subject',60);
            $table->integer('book_id')->unsigned();
            $table->foreign('book_id')->references('id')->on('books');
            $table->timestamps();
        });
         */
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        /*
	    Schema::drop('subjects');	
	    Schema::drop('chapters');	
	    Schema::drop('books');	
         */
	}

}
