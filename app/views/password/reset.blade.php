@extends('base')

@section('header')
<div class="container-header">
  <div class="header-heading">
      <h4>重置密码</h4>
  </div>
  <div class="header-body" style="height:1px;">
  </div>
</div>
@stop

@section('content')
<div class="container-body">
<div class="row" style="margin:20px 0;">
  <div class="col-md-8 col-md-offset-2">

{{ Form::open(array('url'=>route('passwordResetHandle'),'class'=>'form-horizontal','role'=>'form')) }}

{{ Form::hidden('token',$token)}}
@if($errors->has('email'))
   <div class="col-sm-9 col-sm-offset-3 alert alert-danger" role="alert">{{ $errors->first('email') }}</div>
@endif
  <div class="form-group">
    {{Form::label('email','邮箱',array('class'=>'col-sm-3 control-label'))}}
    <div class="col-sm-9">
      {{Form::email('email','',array('class'=>'form-control','placeholder'=>'注册邮箱'))}}
    </div>
  </div>
@if($errors->has('password'))
   <div class="col-sm-9 col-sm-offset-3 alert alert-danger" role="alert">{{ $errors->first('password') }}</div>
@endif
  <div class="form-group">
    {{Form::label('password','密码',array('class'=>'col-sm-3 control-label'))}}
    <div class="col-sm-9">
      {{Form::password('password',array('class'=>'form-control','placeholder'=>'至少6个字符'))}}
    </div>
  </div>
  <div class="form-group">
    {{Form::label('password_confirmation','密码确认',array('class'=>'col-sm-3 control-label'))}}
    <div class="col-sm-9">
      {{Form::password('password_confirmation',array('class'=>'form-control','placeholder'=>'要与密码一致'))}}
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      {{Form::submit('确认修改',array('class'=>'btn btn-success'))}}
    </div>
  </div>
{{ Form::close() }}
  </div>
</div>
</div>
@stop


