<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// pages can be got as guest identity
// auth user will get the same as guest in this version, no personal stuff

Route::get('/', array('as'=>'index','uses'=>'RecommendationController@getIndex'));

// display books, 10 books per page
Route::get('bookstore',array('as'=>'bookstore',function()
{
    $books = Book::paginate(10);
    $data['books'] = $books;

    return View::make('bookstore',$data);
}));

// show searching result
// q(required): searching string
Route::post('search','SearchController@bookSearch');

// show categories recommendation
// {catogory}: category of books recommended
Route::get('recommend/{category}','RecommendationController@getRecommendation'); 


// can be get both as guest and as authenticated user, show in different way
Route::get('bookpage/{book_id}','BookController@getBookPage'); 

//Authentication Layer

Route::group(array('before'=>'guest'),function()
{

    Route::get('login',array('as'=>'login',function()
    {
        return View::make('user.auth.login');
    }));

    Route::get('register',array('as'=>'register',function()
    {
        return View::make('user.auth.register');
    }));

    Route::get('password/forget',array('as'=>'passwordforget', 'uses'=>'RemindersController@getRemind'));

    Route::get('password/reset/{token}',array('as'=>'passwordreset','uses'=>'RemindersController@getReset'));

    Route::get('register/verify/{confirmationCode}', array(
        'as' => 'confirmation_path',
        'uses' => 'AuthController@email_confirm'
    ));


    Route::post('auth/login',array('as'=>'loginHandle','before'=>'csrf','uses'=>'AuthController@login'));

    Route::post('auth/reg',array('as'=>'regHandle','before'=>'csrf','uses'=>'AuthController@reg'));

    Route::post('auth/password/remind',array('as'=>'passwordRemindHandle','before'=>'csrf','uses'=>'RemindersController@postRemind'));

    Route::post('auth/password/reset',array('as'=>'passwordResetHandle','before'=>'csrf','uses'=>'RemindersController@postReset'));

});

Route::get('auth/logout',array('as'=>'logoutHandle','before'=>'auth','uses'=>'AuthController@logout'));

Route::post('auth/modify',array('as'=>'infoModify','before'=>'auth','uses'=>'AuthController@modify'));



//Protect routes need authentication
Route::group(array('before'=>'auth'),function()
{

    // user's personal page, need authentication
    Route::group(array('prefix'=>'user/'),function(){

        Route::get('dashboard',array('as'=>'dashboard','uses'=>'UserController@getDashboard'));

        Route::get('bookshelf',array('as'=>'bookshelf','uses'=>'UserController@getBookshelf'));

        Route::get('wordbook',array('as'=>'wordbook','uses'=>'UserController@getWordbook'));

        Route::get('download/all',array('as'=>'download_all','uses'=>'UserController@downloadAll'));

    });


    // learning routine
    Route::group(array('prefix'=>'routine/'),function(){
        
        Route::get('pick','RoutineController@getPick');

        Route::get('preview',array('as'=>'preview','uses'=>'RoutineController@getPreview'));

        Route::post('pick','RoutineController@postPick');

        Route::post('preview','RoutineController@postPreview');

    });

    // reader
    Route::get('reading','BookController@readBook'); 
});


// AJAX ------------------------------------

Route::group(array('before'=>'auth', 'prefix'=>'ajax/'),function(){

// user's ajax update request to words
    Route::group(array('prefix'=>'word/'), function(){

        // wid (required)
        Route::get('get_detail','WordController@getDetail');

        // wid (required)
        // state (required)
        Route::post('set_state','WordController@setState');

        // wid (required)
        // tag (required)
        Route::post('set_tag','WordController@setTag');

        // words_selected (required)
        // state (required)
        Route::post('set_many_states','WordController@setManyStates');

        // words_selected (required)
        // tag (required)
        Route::post('set_many_tags','WordController@setManyTags');

        // wid (requied)
        // step (requied)
        Route::post('set_step','WordController@setStep');

        //if(type='preview')
        //cid is considered first, if can't find, bid be used
        //if(type='review')
        //only bid is used
        //no arguments is not accepted!
        Route::post('start_learn/{type}','WordController@startLearn');

        //step(required)
        //bid(required)
        Route::get('get_batch','WordController@getBatch');

        // bid(required)
        Route::post('update_preview_progress','WordController@updatePreviewProgress');


    });

// user's ajax update request to books
    Route::group(array('prefix'=>'book/'), function(){

        // bid (required)
        Route::post('add_to_bookshelf','BookController@addToBookshelf');

        // cfi (requied)
        // bid (required)
        // n (requied) :bookmark name
        Route::post('add_bookmark','BookController@addBookmark');

        // cfi (requied)
        // bid (required)
        Route::post('update_progress','BookController@updateProgress');

        // bid (required)
        Route::get('get_bookmarks','BookController@getBookmarks');

    });

});

// API --------------------------------------

Route::group(array('prefix'=>'api'),function(){

    Route::get('/book/brief/{book_id}', 'BookController@getBrief');

    Route::get('/book/detail/{book_id}', 'BookController@getDetail');

    Route::get('/word', 'WordController@getDetail');

    Route::get('/entry', 'WordController@query');

});

Route::get('test',function(){
    return View::make('test');
});
