<?php

class RegistrationController extends BaseController {

    public function store()
    {
        $data = Input::all();

        $rules = array(
            'email'=>'required|email|unique:users',
            'username'=>'required|min:1|max:20',
            'password'=>'required|confirmed|min:6',
        );

        $validator = Validator::make($data,$rules);
        if($validator->fails())
        {
            return Redirect::back()->with('message','The following error occurs')->withInput()->withErrors($validator);
        }
        $confirmation_code = str_random(30);
        User::create([
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Hash::make(Input::get('password')),
            'confirmation_code' => $confirmation_code
        ]);

        Mail::send('emails.verify', array("confirmation_code"=>$confirmation_code), function($message) {
            $message->to(Input::get('email'), Input::get('username'))
                ->subject('Verify your email address');
        });
        return Redirect::route('login');

    }

    public function confirm($confirmation_code)
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

        Flash::message('You have successfully verified your account.');

        return Redirect::route('login_path');
    }

}
