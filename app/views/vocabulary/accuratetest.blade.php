@extends('base')

@section('header')
<div class="container header-move-down">
  <div class="row">
    <div class="col-xs-12">
      <h4 class="pull-left">如果您认识下面的单词，请保留单词前的对勾</h4>
      <button class="btn btn-success pull-right">提交</button>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

@stop

@section('content')
<div class="row">
  <div class="col-sm-8 col-sm-offset-2">
@for($i=0;$i<40;$i++)
    <label class="checkbox-inline" style="width:120px; margin:10px 10px;">
      <input type="checkbox" id="inlineCheckbox1" checked value="option1"> bookworm 
    </label>
@endfor
  </div>
</div>
@stop
