@extends('base')

@section('header')
<div class="container-header">
  <div class="header-heading">
      <h4>登陆账号</h4>
  </div>
  <div class="header-body" style="height:1px;">
  </div>
</div>
@stop

@section('content')
<div class="container-body">
<div class="row" style="margin:20px 0;">
  <div class="col-md-8 col-md-offset-2">

{{ Form::open(array('url'=>'auth/login','class'=>'form-horizontal','role'=>'form')) }}
@if(Session::has('dismatch'))
   <div class="col-sm-9 col-sm-offset-3 alert alert-danger" role="alert">{{Session::get('dismatch');}}</div>
@endif
  <div class="form-group">
    {{Form::label('email','邮箱',array('class'=>'col-sm-3 control-label'))}}
    <div class="col-sm-9">
      {{Form::email('email','',array('class'=>'form-control','placeholder'=>'注册邮箱'))}}
    </div>
  </div>
  <div class="form-group">
    {{Form::label('password','密码',array('class'=>'col-sm-3 control-label'))}}
    <div class="col-sm-9">
      {{Form::password('password',array('class'=>'form-control','placeholder'=>'至少6个字符'))}}
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      {{Form::submit('登陆',array('class'=>'btn btn-success'))}}
      <a href="{{route('passwordforget')}}">忘记密码</a>
    </div>
  </div>
{{ Form::close() }}
  </div>
</div>
</div>
@stop
