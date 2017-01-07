@extends('base')

@section('header')
<div class="container header-move-down">
  <div class="row">
    <div class="col-xs-12">
      <h4 class="pull-left">请快速扫描下面的单词组，并根据自己能够知道解释的单词比例选择对应的选项</h4>
      <button class="btn btn-success pull-right">提交</button>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div id="collins-1" class="panel panel-default">
          <div class="panel-body">
<div class="btn-group btn-group-sm center-block" style="margin-bottom:20px;">
  <button class="btn btn-default">基本不会</button>
  <button class="btn btn-default">小部分</button>
  <button class="btn btn-default">一半</button>
  <button class="btn btn-default">大部分</button>
  <button class="btn btn-default">基本都会</button>
  <div class="clearfix"></div>
</div>
@for($i=0;$i<40;$i++)
            <span class="label label-default" style="background-color:#fff; border-radius:0; color:#333;font-weight:400;  display:inline-block;">vocabulary</span>
@endfor
          </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div id="collins-2" class="panel panel-default">
          <div class="panel-body">
<div class="btn-group btn-group-sm center-block" style="margin-bottom:20px;">
  <button class="btn btn-default">基本不会</button>
  <button class="btn btn-default">小部分</button>
  <button class="btn btn-default">一半</button>
  <button class="btn btn-default">大部分</button>
  <button class="btn btn-default">基本都会</button>
  <div class="clearfix"></div>
</div>
@for($i=0;$i<40;$i++)
            <span class="label label-default" style="background-color:#fff; border-radius:0; color:#333;font-weight:400;  display:inline-block;">vocabulary</span>
@endfor
          </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div id="collins-3" class="panel panel-default">
          <div class="panel-body">
<div class="btn-group btn-group-sm center-block" style="margin-bottom:20px;">
  <button class="btn btn-default">基本不会</button>
  <button class="btn btn-default">小部分</button>
  <button class="btn btn-default">一半</button>
  <button class="btn btn-default">大部分</button>
  <button class="btn btn-default">基本都会</button>
  <div class="clearfix"></div>
</div>
@for($i=0;$i<40;$i++)
            <span class="label label-default" style="background-color:#fff; border-radius:0; color:#333;font-weight:400;  display:inline-block;">vocabulary</span>
@endfor
          </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div id="collins-4" class="panel panel-default">
          <div class="panel-body">
<div class="btn-group btn-group-sm center-block" style="margin-bottom:20px;">
  <button class="btn btn-default">基本不会</button>
  <button class="btn btn-default">小部分</button>
  <button class="btn btn-default">一半</button>
  <button class="btn btn-default">大部分</button>
  <button class="btn btn-default">基本都会</button>
  <div class="clearfix"></div>
</div>
@for($i=0;$i<40;$i++)
            <span class="label label-default" style="background-color:#fff; border-radius:0; color:#333;font-weight:400;  display:inline-block;">vocabulary</span>
@endfor
          </div>
        </div>
    </div>
</div>

@stop
