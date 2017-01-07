<?php

class RemindersController extends Controller {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function getRemind()
	{
		return View::make('password.remind');
	}

	/**
	 * Handle a POST request to remind a user of their password.
	 *
	 * @return Response
	 */
	public function postRemind()
	{
    $messages = array(
        'email.required'=>'您的邮箱没有填写',
        'email.email'=>'这不是一个合法的邮箱地址',
        'email.unique'=>'这个邮箱已经注册',
        'email.exists'=>'该邮箱还没有注册',
        'username.required'=>'您的用户名还没有填写',
        'username.min'=>'用户名长度必须不能少于:min',
        'username.max'=>'用户名长度必须不能多于:max',
        'password.required'=>'您的密码还没有填写',
        'password.min'=>'密码长度必须不能少于:min',
        'password.max'=>'密码长度必须不能多于:max',
        'password.confirmed'=>'两次密码输入不相符',
    );
         $data = Input::all();
         $rules = array(
              'email'=>'required|email|exists:users,email',
          );
          
          $validator = Validator::make($data,$rules,$messages);
          if($validator->fails())
          {
            return Redirect::back()->withInput()->withErrors($validator);
          }
         // $credentials = array('email' => Input::get('email'));
          //return Password::remind($credentials);
          Password::remind(Input::only('email'),function($message){
              $message->subject("Pengci.me密码重置");
          });
          return Redirect::back()->withInput()->with('message','发送成功，请查看邮箱');
          /*
		switch ($response = Password::remind(Input::only('email')))
		{
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::REMINDER_SENT:
				return Redirect::back()->with('status', Lang::get($response));
        }*/
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset($token = null)
	{
		if (is_null($token)) App::abort(404);

		return View::make('password.reset')->with('token', $token);
	}

	/**
	 * Handle a POST request to reset a user's password.
	 *
	 * @return Response
	 */
	public function postReset()
	{
    $messages = array(
        'email.required'=>'您的邮箱没有填写',
        'email.email'=>'这不是一个合法的邮箱地址',
        'email.unique'=>'这个邮箱已经注册',
        'email.exists'=>'该邮箱还没有注册',
        'username.required'=>'您的用户名还没有填写',
        'username.min'=>'用户名长度必须不能少于:min',
        'username.max'=>'用户名长度必须不能多于:max',
        'password.required'=>'您的密码还没有填写',
        'password.min'=>'密码长度必须不能少于:min',
        'password.max'=>'密码长度必须不能多于:max',
        'password.confirmed'=>'两次密码输入不相符',
    );
      $data = Input::all();
      $rules = array(
          'email'=>'required|email|exists:users,email',
          'password'=>'required|min:6|confirmed',
      );
      
      $validator = Validator::make($data,$rules,$messages);
      if($validator->fails())
      {
        return Redirect::back()->withInput()->withErrors($validator);
      }
      
		$credentials = Input::only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = Password::reset($credentials, function($user, $password)
		{
			$user->password = Hash::make($password);

			$user->save();
		});
        return Redirect::route('login')->with('message','密码重置成功，请用新密码登录');
      /*
		switch ($response)
		{
			case Password::INVALID_PASSWORD:
			case Password::INVALID_TOKEN:
			case Password::INVALID_USER:
				return Redirect::back()->with('error', Lang::get($response));

			case Password::PASSWORD_RESET:
				return Redirect::to('/');
        }*/
	}

}
