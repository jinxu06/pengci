@extends('base')

@section('content')
<div style="margin-bottom:100px;"></div>
@for($i=0;$i<0;$i++)
<a class="book-display-brief">
<div class="book-cover">
  <div class="book-title ellipsis">
    <span>Adventure hello yes sdfsfsf dfk dfdfjk sdfsf  sdfsjk sdfsf </span> 
  </div>
  <div class="book-author ellipsis">
    book author
  </div>
  <div class="book-press ellipsis">
    book press
  </div>
</div>
<span class="book-level">
    <span class="glyphicon glyphicon-star"></span>
    <span class="glyphicon glyphicon-star"></span>
    <span class="glyphicon glyphicon-star-empty"></span>
</span>
<span class="book-loved">
    <span class="glyphicon glyphicon-heart"></span> 100
</span>
</a>
@endfor

<a class="book-display-detail">
  <div class="book-info">
  </div>
  <div class="book-cover">
  </div>
  <div class="book-control">
    <button type="button" class="btn btn-warning book-control-bookshelf">加入藏书架</button>
    <button type="button" class="btn btn-success book-control-read">开始阅读</button>
  </div>
</a>
@stop

@section('script')
@stop
