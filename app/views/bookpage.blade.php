@extends('base')

@section('style')
<link href="/packages/bootstrap-switch/dist/css/bootstrap2/bootstrap-switch.min.css" rel="stylesheet"> 
@stop

@section('header')
<div style="height:50px;"></div>
@stop

@section('content')
<div class="container">
  <div class="row">
  <div class="book-display-ultra col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
    <div class="row">
    <div class="col-sm-6">
        <div class="book-cover">
          <div class="book-title ellipsis">
            <span>{{$book->title}}</span> 
          </div>
          <div class="book-author ellipsis">
            <span>{{$book->creator}}</span>
          </div>
          <div class="book-press">
            <span><span class="glyphicon glyphicon-tree-conifer"></span> Pengci</span>
          </div>
        </div>
        <div class="book-control">
        @if($book_state=='read')
            <a type="button" class="btn btn-success" href="/reading?bid={{$book->id}}">继续阅读</a>
        @elseif($book_state=='not own')
            <a id="add-to-bookshelf" type="button" class="btn btn-success">加入藏书架</a>
        @else
            <a type="button" class="btn btn-success" href="/reading?bid={{$book->id}}&cid={{$start_cid}}">开始阅读</a>
        @endif
        </div>
      </div>
      <div class="col-sm-6">
        <div class="book-info">
            <span class="book-info-item book-title ellipsis"><span class="key">书名:</span> <span class="value">{{$book->title}}</span></span>
            <span class="book-info-item book-author ellipsis"><span class="key">作者:</span> <span class="value">{{$book->creator}}</span></span>
            <span class="book-info-item"><span class="key">难度:</span> <span class="value">
                @if($book->difficulty>10000000)
                  <span class="glyphicon glyphicon-star"></span>
                @else
                  <span class="glyphicon glyphicon-star-empty"></span>
                @endif
                @if($book->difficulty>40000000)
                  <span class="glyphicon glyphicon-star"></span>
                @else
                  <span class="glyphicon glyphicon-star-empty"></span>
                @endif
                @if($book->difficulty>80000000)
                  <span class="glyphicon glyphicon-star"></span>
                @else
                  <span class="glyphicon glyphicon-star-empty"></span>
                @endif
            </span></span>
            <span class="book-info-item book-category ellipsis"><span class="key">分类:</span> <span class="value">{{$book->subjects}}</span></span>
            <span class="book-info-item"><span class="key">字数:</span> <span class="value">{{$book->length}}</span></span>
            <span class="book-info-item"><span class="key">阅读:</span> <span class="value"> {{$book->viewed}}次</span></span>
        </div>
      </div>
      </div>
      <div class="row">
      <div class="col-xs-12">
        <div class="book-introduction">
          <p>{{$book->introduction}}</p>
        </div>
      </div>
      </div>
  </div>
  </div>

<div class="row" style="margin-top:40px;">
  <div id="bookpage-chapters" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
        @if($book_state!='not own')
        <div style="margin-bottom:20px;">
          <label for="non-main-hidden-switch" style="margin-right:20px;">过滤非正文</label>
          <input type="checkbox" id="non-main-hidden-switch" name="non-main-hidden-switch" checked style="float:left;">
          <table id="illustration" style="float:right;">
          <tr>
            <td>
              <span class="glyphicon glyphicon-ok"></span>
              已打开
            </td>
            <td>
              <span class="glyphicon glyphicon-gift"></span>
              新解锁章节
            </td>
            <td>
              <span class="glyphicon glyphicon-lock"></span>
              加锁 
            </td>
          </tr>
          </table>
        </div>
        @endif
        <table class="table table-chapters">
    @foreach ($chapters as $chapter)
          <tr class="ch-{{$chapter->state}}" id='ch-{{$chapter->id}}'>
            <td class="chapter-title">
            @if($chapter->state=='open'||$chapter->state=='new'||$chapter->state=='lock'||$chapter->state=='free')
              <h5 class="chapter-heading ellipsis">{{$chapter->heading}}</h5>
            @else
              <h5 class="text-center chapter-heading ellipsis">{{$chapter->heading}}</h5>
            @endif
            </td>
            @if($chapter->state=='open'||$chapter->state=='new'||$chapter->state=='lock'||$chapter->state=='free')
            <td class="button-td">
              @if($chapter->state=='open')
              <button data-cid="{{$chapter->id}}" type="button" class="btn-open btn btn-default">
              @else
              <button data-cid="{{$chapter->id}}" type="button" disabled class="btn btn-default">
              @endif
                <span class="glyphicon glyphicon-list-alt"></span> 
              </button>
              @endif
            </td>
            @if($chapter->state=='open')
            <td class="progress-td">
                <div class="progress">
                  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{$chapter->progress}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$chapter->progress}}%;">
                  </div>
                </div>
            </td>
            @endif
            @if($chapter->state=='new')
            <td class="progress-td">
                <div class="progress">
                  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                  </div>
                </div>
            </td>
                @endif
            @if($chapter->state=='lock')
            <td class="progress-td">
                <div class="progress">
                  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                  </div>
                </div>
            </td>
            @endif
            @if($chapter->state=='lock'||$chapter->state=='new'||$chapter->state=='open'||$chapter->state=='free')
            <td class="state-td">
              @if($chapter->state=='lock')
              <span class="glyphicon glyphicon-lock"></span>
              @endif
              @if($chapter->state=='new')
              <span class="glyphicon glyphicon-gift"></span>
              @endif
              @if($chapter->state=='open')
              <span class="glyphicon glyphicon-ok"></span>
              @endif
            </td>
            @endif
          </tr>
    @endforeach
        </table>
  </div>
</div>
@stop


@section('script')
<script src="/packages/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
<script>
</script>
<script>
$.fn.bootstrapSwitch.defaults.size = 'small';
$.fn.bootstrapSwitch.defaults.onColor = 'success';
$('.ch-free').css("display","none");
$("#non-main-hidden-switch").bootstrapSwitch();
$("#non-main-hidden-switch").on('switchChange.bootstrapSwitch', function() {
    if($(this).is(":checked"))
    {
        $('.ch-free').css("display","none");
    }
    else
    {
        $('.ch-free').css("display","table-row");
    }
});
</script>
<script>
$("[data-toggle='tooltip']").each(function(){
    $(this).tooltip({'container':'body','placement':'right'});
});
</script>
<script>
@if($book_state!='not own')
    @foreach ($chapters as $chapter)
        $('#ch-{{$chapter->id}}.ch-free').click(function(){
            $(window.location).attr('href','/reading?bid={{$book->id}}&cid={{$chapter->id}}');
        });
        $('#ch-{{$chapter->id}}.ch-open').click(function(){
            $(window.location).attr('href','/reading?bid={{$book->id}}&cid={{$chapter->id}}');
        });
        $('#ch-{{$chapter->id}}.ch-new').click(function(){
            $(window.location).attr('href','/routine/pick?bid='+{{$book->id}}+'&cid={{$chapter->id}}');
        });
    @endforeach
@endif
</script>
<script>
$('#add-to-bookshelf').click(function(){
    $.post('/ajax/book/add_to_bookshelf',{bid:{{$book->id}},},function(){
        $(window.location).attr('href','/bookpage/{{$book->id}}');
    });
});

</script>
<script>
$('.ch-free').css("cursor","pointer");
$('.ch-open').css("cursor","pointer");
$('.ch-new').css("cursor","pointer");

$('.ch-free').mouseenter(function(){
    $(this).css("background-color","#f6f6f1");
});
$('.ch-free').mouseleave(function(){
    $(this).css("background-color","#fffff9");
});
$('.ch-open').mouseenter(function(){
    $(this).css("background-color","#f6f6f1");
});
$('.ch-open').mouseleave(function(){
    $(this).css("background-color","#fffff9");
});
$('.ch-new').mouseenter(function(){
    $(this).css("background-color","#f6f6f1");
});
$('.ch-new').mouseleave(function(){
    $(this).css("background-color","#fffff9");
});
$('.ch-open .button-td button').mouseenter(function(){
    $(this).addClass('btn-lg');
});
$('.ch-open .button-td button').mouseleave(function(){
    $(this).removeClass('btn-lg');
});

</script>
<script>
$('.ch-open .btn-open').click(function(e){
    e.stopPropagation();
    var cid = $(this).attr("data-cid");
    $.post('/ajax/word/start_learn/preview',{cid:cid},function(){
        $(window.location).attr('href','/user/wordbook?bl=true&lb={{$book->id}}&lc='+cid);
    });
});
</script>
<script>
@foreach ($chapters as $chapter) 
@if($chapter->state=='open')
$('#ch-{{$chapter->id}} .progress-bar').css("width",'0%');
$.post('/ajax/word/update_preview_progress',{cid:{{$chapter->id}}},function(data){
    var progress = Math.round(data.progress);
    $('#ch-{{$chapter->id}} .progress-bar').css("width",progress+'%');
});
@endif
@endforeach
</script>
@stop
