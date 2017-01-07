@extends('base')

@section("style")
<style>
  #subnav
  {
    padding:10px 90px;
    background-color:#f6f6f1;
    width:100%;
    z-index:100;
}
</style>
@stop

@section('header')
<div class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="assets/bg.jpg" alt="1">
      <div class="carousel-caption">
        ...
      </div>
    </div>
    <div class="item">
      <img src="assets/home-banner-bg.jpg" alt="...">
      <div class="carousel-caption">
        ...
      </div>
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div id="subnav" style="padding-left:105px;">
    <ul class="nav nav-pills nav-collection" role="tablist">
      <li role="presentation"><a href="#c-popular">最受欢迎</a></li>
      <li role="presentation"><a href="#c-famous">名作推荐</a></li>
      <li role="presentation"><a href="#c-latest">最新上架</a></li>
      <li role="presentation"><a href="#c-easy">新手推荐</a></li>
      <li role="presentation"><a href="#c-short">精短作品</a></li>
      <li role="presentation"><a href="#c-hard">高难度挑战</a></li>
    </ul>
</div>
@stop

@section('content')
<div class="container-body">

<div class="book-recommend-row">
  <span id="c-popular" class="row-anchor"></span>
  <h4 class="book-recommend-heading">最受欢迎</h4>
  <a href="/recommend/popular" class="custom-link book-recommend-link">更多&gt&gt&gt</a>
  <div class="clearfix"></div>
  <div class="book-recommend-content">
  @foreach ($popular as $book)
    <a href='/bookpage/{{$book->id}}' class="book-display-brief">
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
    <span class="book-level">
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
    </span>
    <span class="book-viewed">
        <span class="glyphicon glyphicon-eye-open"></span> {{$book->viewed}} 
    </span>
    </a>
  @endforeach
  </div>
</div>

<div class="book-recommend-row">
  <span id="c-famous" class="row-anchor"></span>
  <h4 class="book-recommend-heading">名作推荐</h4>
  <a href="/recommend/famous" class="custom-link book-recommend-link">更多&gt&gt&gt</a>
  <div class="clearfix"></div>
  <div class="book-recommend-content">
  @foreach ($famous as $book)
    <a href="/bookpage/{{$book->id}}" class="book-display-brief">
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
    <span class="book-level">
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
    </span>
    <span class="book-viewed">
        <span class="glyphicon glyphicon-eye-open"></span> {{$book->viewed}} 
    </span>
    </a>
  @endforeach
  </div>
</div>

<div class="book-recommend-row">
  <span id="c-latest" class="row-anchor"></span>
  <h4 class="book-recommend-heading">最新上架</h4>
  <a href="/recommend/latest" class="custom-link book-recommend-link">更多&gt&gt&gt</a>
  <div class="clearfix"></div>
  <div class="book-recommend-content">
  @foreach ($latest as $book)
    <a href="/bookpage/{{$book->id}}" class="book-display-brief">
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
    <span class="book-level">
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
    </span>
    <span class="book-viewed">
        <span class="glyphicon glyphicon-eye-open"></span> {{$book->viewed}} 
    </span>
    </a>
  @endforeach
  </div>
</div>

<div class="book-recommend-row">
  <span id="c-easy" class="row-anchor"></span>
  <h4 class="book-recommend-heading">新手推荐</h4>
  <a href="/recommend/easy" class="custom-link book-recommend-link">更多&gt&gt&gt</a>
  <div class="clearfix"></div>
  <div class="book-recommend-content">
  @foreach ($easy as $book)
    <a href="/bookpage/{{$book->id}}" class="book-display-brief">
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
    <span class="book-level">
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
    </span>
    <span class="book-viewed">
        <span class="glyphicon glyphicon-eye-open"></span> {{$book->viewed}} 
    </span>
    </a>
  @endforeach
  </div>
</div>

<div class="book-recommend-row">
  <span id="c-short" class="row-anchor"></span>
  <h4 class="book-recommend-heading">精短作品</h4>
  <a href="/recommend/short" class="custom-link book-recommend-link">更多&gt&gt&gt</a>
  <div class="clearfix"></div>
  <div class="book-recommend-content">
  @foreach ($short as $book)
    <a href="/bookpage/{{$book->id}}" class="book-display-brief">
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
    <span class="book-level">
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
    </span>
    <span class="book-viewed">
        <span class="glyphicon glyphicon-eye-open"></span> {{$book->viewed}} 
    </span>
    </a>
  @endforeach
  </div>
</div>

<div class="book-recommend-row">
  <span id="c-hard" class="row-anchor"></span>
  <h4 class="book-recommend-heading">高难度挑战</h4>
  <a href="/recommend/hard" class="custom-link book-recommend-link">更多&gt&gt&gt</a>
  <div class="clearfix"></div>
  <div class="book-recommend-content">
  @foreach ($hard as $book)
    <a href="/bookpage/{{$book->id}}" class="book-display-brief">
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
    <span class="book-level">
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
    </span>
    <span class="book-viewed">
        <span class="glyphicon glyphicon-eye-open"></span> {{$book->viewed}} 
    </span>
    </a>
  @endforeach
  </div>
</div>

</div>
@stop


@section('script')
<script>
$('nav').removeClass("navbar-normal");
$('nav').addClass("navbar-transparent");

$(document).scroll(function(){
    if($(this).scrollTop()>297)
    {
        if($('nav').hasClass("navbar-transparent"))
        {
            $('nav').removeClass("navbar-transparent");
            $('nav').addClass("navbar-normal");
        }
    }
    else
    {
        if($('nav').hasClass("navbar-normal"))
        {
            $('nav').removeClass("navbar-normal");
            $('nav').addClass("navbar-transparent");
        }
    }
    if($(this).scrollTop()>297)
    {
        $('#subnav').css({"position":"fixed","top":"50px","border-top":"2px solid #825d5b"});
    }
    else
    {
        $('#subnav').css({"position":"static","top":"0"});
    }
});
</script>
@stop
