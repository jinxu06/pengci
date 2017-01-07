@extends('base')

@section('header')
<div class="container-header">
  <div class="header-heading">
    <h3 class="pull-left" style="margin:0;">为您推荐的书</h3>
    <div class="clearfix"></div>
  </div>
</div>
@stop

@section('content')
<div class="container-body">
@foreach ($books as $book)
        <a href="/bookpage/{{$book->id}}" class="book-display-detail">
          <div class="book-info">
            <span class="book-info-item book-title ellipsis"><span class="key">书名:</span> <span class="value">{{$book->title}}</span></span>
            <span class="book-info-item book-introduction ellipsis"><span class="key">简介:</span> <span class="value">{{$book->introduction}}</span></span>
            <span class="book-info-item book-author ellipsis"><span class="key">作者:</span> <span class="value">{{$book->creator}}</span></span>
            <span class="book-info-item book-category ellipsis"><span class="key">分类:</span> <span class="value">{{$book->subjects}}</span></span>
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
            <span class="book-info-item"><span class="key">收藏:</span> <span class="value">{{$book->viewed}}次</span></span>
          </div> 
          <div class="book-cover">
              <div class="book-title ellipsis">
                <span>{{$book->title}}</span> 
              </div>
              <div class="book-author ellipsis">
                <span>{{$book->creator}}</span>
              </div>
              <div class="book-press ellipsis">
                <span><span class="glyphicon glyphicon-tree-conifer"></span> Pengci</span>
              </div>
          </div> 
          <div class="book-control">
@if(!$book->ownership)
            <button data-bid="{{$book->id}}" type="button" class="btn btn-warning book-control-bookshelf">加入藏书架</button>
@else
            <button data-bid="{{$book->id}}" type="button" class="btn btn-warning book-control-bookshelf" disabled>在架上 <span class="glyphicon glyphicon-ok"></span></button>
@endif
            <button data-bid="{{$book->id}}" type="button" class="btn btn-success book-control-read">前往阅读</button>
          </div> 
        </a>
@endforeach
</div>

@stop
