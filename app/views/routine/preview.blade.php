@extends('base')

@section('header')
<div class="container-header">
  <div class="routine-indicator">
    <div class="routine-circle routine-processed"><h6 class="routine-number text-center">1</h6></div> 
    <div class="routine-line routine-processed"><h6 class="routine-text text-center">选择书籍</h6></div> 
    <div class="routine-circle routine-processed"><h6 class="routine-number text-center">2</h6></div> 
    <div class="routine-line routine-processed"><h6 class="routine-text text-center">提取单词</h6></div> 
    <div class="routine-circle routine-processed"><h6 class="routine-number text-center">3</h6></div> 
    <div class="routine-line"><h6 class="routine-text text-center">预习生词</h6></div> 
    <div class="routine-circle"><h6 class="routine-number text-center">4</h6></div> 
    <div class="clearfix"></div>
  </div>
</div>
@stop

@section('content')
<div class="container-body" style="text-align:center;">
  <h3>本章节一共为您生成了{{Session::get('words_count')}}个生词</h3>
  <a id="start-learn" class="btn btn-success" style="margin-top:40px;">开始学习</a>
</div>


@stop

@section('script')
<script>
$('#start-learn').click(function(){
    $.post('/ajax/word/start_learn/preview',{cid:{{Session::get('chapter_id')}}},function(){
        $(window.location).attr('href','/user/wordbook?bl=true&lb={{Session::get("book_id")}}&lc={{Session::get("chapter_id")}}');
    });
});
</script>
@stop
