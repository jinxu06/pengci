@extends('user.userbase')
@section('user_content')

<div class="container">
    <div class="row" style="margin:24px 0;">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <h4 class="text-center"> 修改个人信息，注册邮箱不可更改</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        {{Form::open(array('url'=>'auth/modify','method'=>'post','class'=>'form-horizontal','role'=>'form'))}}
          <div class="form-group">
            {{Form::label('email','邮箱',array('class'=>'col-sm-3 control-label'))}}
            <div class="col-sm-8">
              {{Form::email('email',$user->email,array('class'=>'form-control','readonly'=>'readonly'))}}
            </div>
          </div>
        @if($errors->has('username'))
           <div class="col-sm-9 col-sm-offset-3 alert alert-danger" role="alert">{{ $errors->first('username') }}</div>
        @endif
          <div class="form-group">
            {{Form::label('username','用户名',array('class'=>'col-sm-3 control-label'))}}
            <div class="col-sm-8">
              {{Form::text('username',$user->username,array('id'=>'username_input','class'=>'form-control','disabled'=>'disabled'))}}
            </div>
            <a id="username_modi" class="col-sm-1" style="position:relative; top:8px;"><span class="glyphicon glyphicon-pencil"></span></a>
          </div>
        @if($errors->has('password'))
           <div class="col-sm-9 col-sm-offset-3 alert alert-danger" role="alert">{{ $errors->first('password') }}</div>
        @endif
          <div class="form-group">
            {{Form::label('password','密码',array('class'=>'col-sm-3 control-label'))}}
            <div class="col-sm-8">
              {{Form::password('password',array('value'=>$user->password,'id'=>'password_input','class'=>'form-control','disabled'=>'disabled','placeholder'=>'至少6个字符'))}}
            </div>
            <a id="password_modi" class="col-sm-1" style="position:relative; top:8px;"><span class="glyphicon glyphicon-pencil"></span></a>
          </div>
          <div class="form-group" id="confirmation_input" style="display:none;">
            {{Form::label('password_confirmation','密码确认',array('class'=>'col-sm-3 control-label'))}}
            <div class="col-sm-8">
              {{Form::password('password_confirmation',array('class'=>'form-control','placeholder'=>'要与密码一致'))}}
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              {{Form::submit('修改',array('class'=>'btn btn-success'))}}
            </div>
          </div>
        {{Form::close()}}
        </div>
    </div>
</div>
@stop


@section('user_script')
  <script>
     $('#username_modi').click(function(){
         if($('#username_modi>span').attr("class")=="glyphicon glyphicon-ban-circle")
         {
             $('#username_input').attr("disabled","disabled");
             $('#username_modi>span').attr("class","glyphicon glyphicon-pencil");
         }
         else
         {
             $('#username_input').removeAttr("disabled");
             $('#username_modi>span').attr("class","glyphicon glyphicon-ban-circle");
         }
     }); 


     $('#password_modi').click(function(){
         if($('#password_modi>span').attr("class")=="glyphicon glyphicon-ban-circle")
         {
             $('#password_input').attr("disabled","disabled");
             $('#password_modi>span').attr("class","glyphicon glyphicon-pencil");
             $('#confirmation_input').css("display","none");
         }
         else
         {
             $('#password_input').removeAttr("disabled");
             $('#password_modi>span').attr("class","glyphicon glyphicon-ban-circle");
             $('#confirmation_input').css("display","block");
         }
     }); 
  </script>
@stop
