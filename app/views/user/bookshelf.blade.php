@extends('user.userbase')

@section('user_content')
<div class="container-body">
@foreach ($books as $book)
    <a href="/bookpage/{{$book->id}}" class="book-display-normal">
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
            <span class="book-info-item"><span class="key">字数:</span> <span class="value">{{$book->length}}</span></span>
            <span class="book-info-item book-progress ellipsis"><span class="key">进度:</span> <span class="value">{{$book->progress}}</span></span>
        </div>
    </a>
@endforeach
</div>
@stop
