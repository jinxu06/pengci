@extends('base')

@section('style')
<link href="/packages/autocomplete/jquery.autocomplete.css"></link>
@stop

@section('header')
<div class="container-header">
  <div class="header-heading">
    <h4>全部书籍</h4>
  </div>
  <div class="header-body">
   <div class="pull-left">
        <ul class="nav nav-pills nav-collection" role="tablist">
          <li role="presentation" class="active"><a href="#">全部</a></li>
          <li role="presentation"><a href="#">文学</a></li>
          <li role="presentation"><a href="#">悬疑</a></li>
          <li role="presentation"><a href="#">科学</a></li>
          <li role="presentation"><a href="#">传记</a></li>
          <li role="presentation"><a href="#">人物</a></li>
          <li role="presentation"><a href="#">历史</a></li>
        </ul>   
    </div>
    <form action="/search" method="POST" class="form-inline pull-right" role="form" style="width:300px;">
      <div class="input-group" style="width:100%;">
        <input id="search-box" name="q" type="text" class="form-control">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success" type="button"><span class="glyphicon glyphicon-search"></span></button>
        </span>
      </div>
    </form>
    <div class="clearfix"></div>
  </div>
</div>
@stop

@section('content')

<div class="container-body">
@foreach ($books as $book)
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
<div>
{{ $books->links() }}
</div>
</div>
@stop


@section('script')
<script src="/packages/autocomplete/jquery.autocomplete.js"></script>
<script>
/*
var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California'];
$('#search-box').autocomplete({
    source: [states],
    render: function( item,source,pid,query ){
              var value = item[this.valueKey],
                  title = item[this.titleKey];
              return '<li '+(value==query?'class="active"':'')+
                    ' data-value="'+
                      encodeURIComponent(value)+'">'+
                        title+
                          '</div>';
            }
});
*
</script>
@stop
