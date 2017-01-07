<?php

class AuthController extends BaseController{

  public function reg()
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
        'email'=>'required|email|unique:users',
        'username'=>'required|min:1|max:20',
        'password'=>'required|confirmed|min:6',
    );

    $validator = Validator::make($data,$rules,$messages);
    if($validator->fails())
    {
        return Redirect::back()->withInput()->withErrors($validator);
    }

    $confirmation_code = str_random(30);
    $user = new User();
    $user->email = Input::get('email');
    $user->username = Input::get('username');
    $user->password = Hash::make(Input::get('password'));
    $user->confirmation_code = $confirmation_code;
    $user->save();

    Mail::send('emails.verify', array("confirmation_code"=>$confirmation_code), function($message) {
        $message->to(Input::get('email'), Input::get('username'))
            ->subject('Pengci.me邮箱验证');
    });

    return Redirect::route('login')->with('message','您只要先验证邮箱才能登陆');
  }

    public function email_confirm($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        return Redirect::route('login');
    }

  public function login()
  {
      if(Input::has('email'))
      {
          if(! User::where('email','=',Input::get('email'))->first()->confirmed)
          {
              return Redirect::route('login')->with('dismatch', '用户邮箱没有验证,请先去邮箱进行验证')->withInput();
          }
      }
      $credentials = array(
          'email'=>Input::get('email'),
          'password'=>Input::get('password'),
          'confirmed'=>1,
      );
      if (Auth::attempt($credentials,true)) {
              return Redirect::intended('user/dashboard');
      } 
      else {
              return Redirect::route('login')->with('dismatch', '注册邮箱或是密码输入不正确')->withInput();
      }
  }


  public function modify()
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
        'username'=>'min:1|max:20',
        'password'=>'confirmed|min:6|max:20',
    );

    $validator = Validator::make($data,$rules,$messages);
    if($validator->fails())
    {
        return Redirect::back()->withInput()->withErrors($validator);
    }

    if(Input::has('username'))
    {
        User::where('email','=',Input::get('email'))->update(array(
            'username'=>Input::get('username'),
        ));
    }

    if(Input::has('password'))
    {
        User::where('email','=',Input::get('email'))->update(array(
            'password'=>Hash::make(Input::get('password')),
        ));
    }

    if(Input::has('username')&&Input::has('password')){
        return Redirect::back()->withInput()->with('message','已使用新的用户名和密码');
    }
    else if((! Input::has('username'))&&Input::has('password')){
        return Redirect::back()->withInput()->with('message','已使用新的密码');
    }
    else if(Input::has('username')&&(!Input::has('password'))){
        return Redirect::back()->withInput()->with('message','已使用新的用户名');
    }
    else{
        return Redirect::back()->withInput()->with('message','提交了空表单，没有修改');
    }

  }

  public function logout()
  {
      Auth::logout();
      return Redirect::to('/');
  }

}
