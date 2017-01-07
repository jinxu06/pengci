@extends('base')

@section('header')
<div class="container header-move-down">
  <div class="row">
    <div class="col-xs-12">
      <h4 class="pull-left">测试结果</h4>
      <button class="btn btn-success pull-right" style="margin:10px;">提交</button>
      <button class="btn btn-primary pull-right" style="margin:10px;">再来一次</button>
    </div>
  </div>
</div>
@stop

@section('content')
<div class="row">
  <div class="col-sm-8 col-sm-offset-2" style="padding-top:100px;">
    <h3 class="text-warning" style="color:#f0ad4e;">我们估计您的单词量为</h3>
    <h1 class="text-primary">5000!</h1>
  </div>
</div>
@stop
