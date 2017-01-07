@extends('base')

@section('header')
<div class="container-header">
  <div class="header-heading">
      <div class="routine-indicator">
        <div class="routine-circle routine-processed"><h6 class="routine-number text-center">1</h6></div> 
        <div class="routine-line routine-processed"><h6 class="routine-text text-center">选择书籍</h6></div> 
        <div class="routine-circle routine-processed"><h6 class="routine-number text-center">2</h6></div> 
        <div class="routine-line"><h6 class="routine-text text-center">提取单词</h6></div> 
        <div class="routine-circle"><h6 class="routine-number text-center">3</h6></div> 
        <div class="routine-line"><h6 class="routine-text text-center">预习生词</h6></div> 
        <div class="routine-circle"><h6 class="routine-number text-center">4</h6></div> 
        <div class="clearfix"></div>
      </div>
  </div>
  <div class="header-body">
      <h4>请从下面的章节中提取的单词中去除你觉得简单的单词，它们将不会在后面出现，同时我们会根据选择对您的词汇量有更多的了解</h4>
  </div>
</div>
@stop

@section('content')
<div class="container-body">

<h4 class="pull-left">{{$book->title}} <small>{{$chapter->heading}}</small></h4>
<button class="pull-right btn btn-success" onclick="$('#wordlist').submit();">下一步</button>
<div class="clearfix"></div>

<div class="panel panel-default" style="margin-top:40px;">

    <div class="panel panel-heading">
      <div class="fast-pick">
          <label class="checkbox-inline">
            <input id="cp-all" type="checkbox" checked value="all">全部
          </label>
      </div>
      <div class="fast-pick">
          <label class="checkbox-inline">
            <input id="cp-collins-none" type="checkbox" checked value="collins-none">Collins-None
          </label>
    @for($index=0;$index<=5;$index++)
          <label class="checkbox-inline">
            <input id="cp-collins-{{$index}}" type="checkbox" checked value="collins-{{$index}}">Collins-{{$index}}
          </label>
    @endfor
      </div>
    </div>

    <div class="panel-body">
    <form id="wordlist" action="/routine/pick" method="POST">
    {{Form::open(array('url'=>'/routine/pick','method'=>'post','role'=>'form'))}}
    <input type="hidden" name='cid' value='{{$chapter->id}}'>
    @foreach ($words as $word)
        <div class="word-pick">
          <label class="checkbox-inline">
            <input name="words_selected[]" class="word-check collins{{$word->collins_level}}" type="checkbox" checked value="{{$word->id}}">{{$word->word}}
          </label>
        </div>
    @endforeach
    {{ Form::close() }}
    </div>

</div>

</div>
@stop


@section('script')
<script>
$('#cp-all').click(function(){
    if($(this).is(":checked"))
    {
        $('.word-check').prop("checked",true);
    }
    else
    {
        $('.word-check').prop("checked",false);
    }
});
@for($index=0;$index<=5;$index++)
$('#cp-collins-{{$index}}').click(function(){
    if($(this).is(":checked"))
    {
        $('.word-check.collins{{$index}}').prop("checked",true);
    }
    else
    {
        $('.word-check.collins{{$index}}').prop("checked",false);
    }
});
  
@endfor
</script>
@stop
