<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        /*
	    Schema::create('users',function($table){
            $table->increments('id');
            $table->string('email',255)->unique();
            $table->string('username',128);
            $table->string('password',60);
            $table->tinyInteger('level')->default(8);
            $table->string('confirmation_code')->nullable();
            $table->boolean('confirmed')->default(0);
            $table->rememberToken();
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
	   // Schema::drop('users');	
	}

}
