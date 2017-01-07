@extends('user.userbase')

@section('user_content')

<div class="container-body">

<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>单词本下载</strong> 我们还提供了用户单词下载以方便您导入到有道单词本中进行学习 
  <br>
  <form class="form-inline" role="form">
    <button id="download-all" class="btn btn-success" style="margin:10px 0;">下载</button>
  </form>
</div>

@if($review_words_count)
<div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>复习任务</strong> 您今天还有{{$review_words_count}}个单词需要复习，赶快去看看吧 
  <br>
  <form class="form-inline" role="form">
    <div class="form-group">
      <select id="review-book-selector" class="form-control" style="width:200px;">
      @foreach ($user_books as $book)
        <option value="{{$book->id}}">{{$book->title}}</option>
      @endforeach
      </select>
    </div>
    <button id="begin-review" class="btn btn-success" style="margin:10px 0;">开始复习</button>
  </form>
</div>
@endif

@if($preview_words_count)
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>预习计划</strong> 您有{{$preview_words_count}}个单词还没有预习,强烈建议您在阅读之前完成预习。 
  <br>
  <form class="form-inline" role="form">
    <div class="form-group">
      <select id="preview-book-selector" class="form-control" style="width:200px;">
      @foreach ($user_books as $book)
        <option value="{{$book->id}}">{{$book->title}}</option>
      @endforeach
      </select>
      <select id="preview-chapter-selector" class="form-control" style="width:200px;">
      @foreach ($user_chapters as $chapter)
        <option value="{{$chapter->id}}" class="belongto-{{$chapter->book_id}}" style="display:none;">{{$chapter->heading}}</option>
      @endforeach
      </select>
    </div>
  <button id="begin-preview" class="btn btn-success" style="margin:10px 0;">开始预习</button>
  </form>
</div>
@endif


<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li id="tab-preview" role="presentation"><a href="#panel-preview" role="tab" data-toggle="tab">新单词预习</a></li>
  <li id="tab-review" role="presentation"><a href="#panel-review" role="tab" data-toggle="tab">复习任务</a></li>
  <li id="tab-all" role="presentation"><a href="#panel-all" role="tab" data-toggle="tab">全部单词</a></li>
  <li id="tab-normal" role="presentation"><a href="#panel-normal" role="tab" data-toggle="tab">重点词</a></li>
  <li id="tab-easy" role="presentation"><a href="#panel-easy" role="tab" data-toggle="tab">简单词</a></li>
  <li id="tab-rare" role="presentation"><a href="#panel-rare" role="tab" data-toggle="tab">冷僻词</a></li>
  <li id="tab-discard" role="presentation"><a href="#panel-discard" role="tab" data-toggle="tab">回收站</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane" id="panel-preview">

    <div class="checkbox pull-left">
      <label>
        <input class="checkall" checked type="checkbox">全选
      </label>
    </div>

    <a class="advanced-select pull-left" style="margin:10px 20px; margin-right:30px; display:block;">高级筛选<span class="glyphicon glyphicon-chevron-down"></span></a>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        状态标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-preview">待预习</a></li>
        <li><a class="massive-review">待复习</a></li>
        <li><a class="massive-end">完全掌握</a></li>
        <li><a class="massive-none">下次再背</a></li>
      </ul>
    </div>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        难度标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-easy">简单</a></li>
        <li><a class="massive-normal">重点</a></li>
        <li><a class="massive-rare">生僻</a></li>
      </ul>
    </div>
 
    <a class="massive-discard btn btn-danger pull-left">删除</a>
 
    <button  class="page-refresh hidden-sm btn btn-default" style="margin-left:60px;">
        <span class="glyphicon glyphicon-refresh"></span>
    </button>

    <div class="clearfix" style="margin-bottom:20px;"></div>

@if($selected_book_id)
<div class="advanced-select-row row" style="display:block;">
@else
<div class="advanced-select-row row" style="display:none;">
@endif
  <div class="col-xs-12">
  <form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="book-select" class="col-sm-3 control-label">选择书籍 :</label>
        <div class="col-sm-9">
            <select name="book-select" class="book-select form-control">
              <option value="">所有</option>
    @foreach ($user_books as $book)
      @if($book->id==$selected_book_id)
              <option selected value="{{$book->id}}">{{$book->title}}</option> 
      @else
              <option value="{{$book->id}}">{{$book->title}}</option> 
      @endif
    @endforeach
            </select>
        </div>
    </div>
  </form>
  </div>
</div>
<form id="form-preview">
    <table class="table table-striped">
@foreach ($words as $word)
@if($word->state=='preview')
      <tr class="word-{{$word->id}}">
        <td class="checkbox-td">
          <input class="word-checkbox" checked type="checkbox" value="{{$word->id}}">
        </td>
        <td class="word-td">
            {{$word->word}}
        </td>
        <td class="state-td">
        <select class="word-state-{{$word->id}} form-control">
@if($word->state=='preview')
          <option selected value="preview">待预习</option>
@else
          <option value="preview">待预习</option>
@endif
@if($word->state=='review')
          <option selected value="review">待复习</option>
@else
          <option value="review">待复习</option>
@endif
@if($word->state=='end')
          <option selected value="end">完全掌握</option>
@else
          <option value="end">完全掌握</option>
@endif
@if($word->state=='none')
          <option value="none">下次再背</option>
@else
          <option value="none">下次再背</option>
@endif
        </select>
        </td>
        <td class="tag-td">
        <select class="word-tag-{{$word->id}} form-control">
@if($word->tag=='normal')
           <option selected value="normal">重点</option>
@else
           <option value="normal">重点</option>
@endif
@if($word->tag=='easy')
           <option selected value="easy">简单</option>
@else
           <option value="easy">简单</option>
@endif
@if($word->tag=='rare')
           <option selected value="rare">生僻</option>
@else
           <option value="rare">生僻</option>
@endif
        </select>
        </td>
        <td class="detail-td">
          <a data-wid='{{$word->id}}' class="get-word-detail">详情</a>
        </td>
        <td class="delete-td">
          <a class="word-del-{{$word->id}}">删除</a>
        </td>
      </tr>
@endif
@endforeach
    </table>
</form>
  </div>
<div role="tabpanel" class="tab-pane" id="panel-review">

    <div class="checkbox pull-left">
      <label>
        <input class="checkall" checked type="checkbox">全选
      </label>
    </div>

    <a class="advanced-select pull-left" style="margin:10px 20px; margin-right:30px; display:block;">高级筛选<span class="glyphicon glyphicon-chevron-down"></span></a>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        状态标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-preview">待预习</a></li>
        <li><a class="massive-review">待复习</a></li>
        <li><a class="massive-end">完全掌握</a></li>
        <li><a class="massive-none">下次再背</a></li>
      </ul>
    </div>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        难度标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-easy">简单</a></li>
        <li><a class="massive-normal">重点</a></li>
        <li><a class="massive-rare">生僻</a></li>
      </ul>
    </div>
 
    <a class="massive-discard btn btn-danger pull-left">删除</a>
 
    <button  class="page-refresh hidden-sm btn btn-default" style="margin-left:60px;">
        <span class="glyphicon glyphicon-refresh"></span>
    </button>

    <div class="clearfix" style="margin-bottom:20px;"></div>

@if($selected_book_id)
<div class="advanced-select-row row" style="display:block;">
@else
<div class="advanced-select-row row" style="display:none;">
@endif
  <div class="col-xs-12">
  <form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="book-select" class="col-sm-3 control-label">选择书籍 :</label>
        <div class="col-sm-9">
            <select name="book-select" class="book-select form-control">
              <option value="">所有</option>
    @foreach ($user_books as $book)
      @if($book->id==$selected_book_id)
              <option selected value="{{$book->id}}">{{$book->title}}</option> 
      @else
              <option value="{{$book->id}}">{{$book->title}}</option> 
      @endif
    @endforeach
            </select>
        </div>
    </div>
  </form>
  </div>
</div>
<form id="form-preview">
    <table class="table table-striped">
@foreach ($words as $word)
@if($word->state=='review')
      <tr class="word-{{$word->id}}">
        <td class="checkbox-td">
          <input class="word-checkbox" checked type="checkbox" value="{{$word->id}}">
        </td>
        <td class="word-td">
            {{$word->word}}
        </td>
        <td class="state-td">
        <select class="word-state-{{$word->id}} form-control">
@if($word->state=='preview')
          <option selected value="preview">待预习</option>
@else
          <option value="preview">待预习</option>
@endif
@if($word->state=='review')
          <option selected value="review">待复习</option>
@else
          <option value="review">待复习</option>
@endif
@if($word->state=='end')
          <option selected value="end">完全掌握</option>
@else
          <option value="end">完全掌握</option>
@endif
@if($word->state=='none')
          <option value="none">下次再背</option>
@else
          <option value="none">下次再背</option>
@endif
        </select>
        </td>
        <td class="tag-td">
        <select class="word-tag-{{$word->id}} form-control">
@if($word->tag=='normal')
           <option selected value="normal">重点</option>
@else
           <option value="normal">重点</option>
@endif
@if($word->tag=='easy')
           <option selected value="easy">简单</option>
@else
           <option value="easy">简单</option>
@endif
@if($word->tag=='rare')
           <option selected value="rare">生僻</option>
@else
           <option value="rare">生僻</option>
@endif
        </select>
        </td>
        <td class="detail-td">
          <a data-wid='{{$word->id}}' class="get-word-detail">详情</a>
        </td>
        <td class="delete-td">
          <a class="word-del-{{$word->id}}">删除</a>
        </td>
      </tr>
@endif
@endforeach
    </table>
</form>
</div>
<div role="tabpanel" class="tab-pane" id="panel-all">
    <div class="checkbox pull-left">
      <label>
        <input class="checkall" checked type="checkbox">全选
      </label>
    </div>

    <a class="advanced-select pull-left" style="margin:10px 20px; margin-right:30px; display:block;">高级筛选<span class="glyphicon glyphicon-chevron-down"></span></a>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        状态标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-preview">待预习</a></li>
        <li><a class="massive-review">待复习</a></li>
        <li><a class="massive-end">完全掌握</a></li>
        <li><a class="massive-none">下次再背</a></li>
      </ul>
    </div>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        难度标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-easy">简单</a></li>
        <li><a class="massive-normal">重点</a></li>
        <li><a class="massive-rare">生僻</a></li>
      </ul>
    </div>
 
    <a class="massive-discard btn btn-danger pull-left">删除</a>
 
    <button  class="page-refresh hidden-sm btn btn-default" style="margin-left:60px;">
        <span class="glyphicon glyphicon-refresh"></span>
    </button>

    <div class="clearfix" style="margin-bottom:20px;"></div>

@if($selected_book_id)
<div class="advanced-select-row row" style="display:block;">
@else
<div class="advanced-select-row row" style="display:none;">
@endif
  <div class="col-xs-12">
  <form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="book-select" class="col-sm-3 control-label">选择书籍 :</label>
        <div class="col-sm-9">
            <select name="book-select" class="book-select form-control">
              <option value="">所有</option>
    @foreach ($user_books as $book)
      @if($book->id==$selected_book_id)
              <option selected value="{{$book->id}}">{{$book->title}}</option> 
      @else
              <option value="{{$book->id}}">{{$book->title}}</option> 
      @endif
    @endforeach
            </select>
        </div>
    </div>
  </form>
  </div>
</div>
<form id="form-all">
    <table class="table table-striped">
@foreach ($words as $word)
@if($word->state=='review'||$word->state=='preview'||$word->state=='end')
      <tr class="word-{{$word->id}}">
        <td class="checkbox-td">
          <input class="word-checkbox" checked type="checkbox" value="{{$word->id}}">
        </td>
        <td class="word-td">
            {{$word->word}}
        </td>
        <td class="state-td">
        <select class="word-state-{{$word->id}} form-control">
@if($word->state=='preview')
          <option selected value="preview">待预习</option>
@else
          <option value="preview">待预习</option>
@endif
@if($word->state=='review')
          <option selected value="review">待复习</option>
@else
          <option value="review">待复习</option>
@endif
@if($word->state=='end')
          <option selected value="end">完全掌握</option>
@else
          <option value="end">完全掌握</option>
@endif
@if($word->state=='none')
          <option value="none">下次再背</option>
@else
          <option value="none">下次再背</option>
@endif
        </select>
        </td>
        <td class="tag-td">
        <select class="word-tag-{{$word->id}} form-control">
@if($word->tag=='normal')
           <option selected value="normal">重点</option>
@else
           <option value="normal">重点</option>
@endif
@if($word->tag=='easy')
           <option selected value="easy">简单</option>
@else
           <option value="easy">简单</option>
@endif
@if($word->tag=='rare')
           <option selected value="rare">生僻</option>
@else
           <option value="rare">生僻</option>
@endif
        </select>
        </td>
        <td class="detail-td">
          <a data-wid='{{$word->id}}' class="get-word-detail">详情</a>
        </td>
        <td class="delete-td">
          <a class="word-del-{{$word->id}}">删除</a>
        </td>
      </tr>
@endif
@endforeach
    </table>
</form>
</div>
<div role="tabpanel" class="tab-pane" id="panel-normal">

    <div class="checkbox pull-left">
      <label>
        <input class="checkall" checked type="checkbox">全选
      </label>
    </div>

    <a class="advanced-select pull-left" style="margin:10px 20px; margin-right:30px; display:block;">高级筛选<span class="glyphicon glyphicon-chevron-down"></span></a>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        状态标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-preview">待预习</a></li>
        <li><a class="massive-review">待复习</a></li>
        <li><a class="massive-end">完全掌握</a></li>
        <li><a class="massive-none">下次再背</a></li>
      </ul>
    </div>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        难度标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-easy">简单</a></li>
        <li><a class="massive-normal">重点</a></li>
        <li><a class="massive-rare">生僻</a></li>
      </ul>
    </div>
 
    <a class="massive-discard btn btn-danger pull-left">删除</a>
 
    <button  class="page-refresh hidden-sm btn btn-default" style="margin-left:60px;">
        <span class="glyphicon glyphicon-refresh"></span>
    </button>

    <div class="clearfix" style="margin-bottom:20px;"></div>

@if($selected_book_id)
<div class="advanced-select-row row" style="display:block;">
@else
<div class="advanced-select-row row" style="display:none;">
@endif
  <div class="col-xs-12">
  <form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="book-select" class="col-sm-3 control-label">选择书籍 :</label>
        <div class="col-sm-9">
            <select name="book-select" class="book-select form-control">
              <option value="">所有</option>
    @foreach ($user_books as $book)
      @if($book->id==$selected_book_id)
              <option selected value="{{$book->id}}">{{$book->title}}</option> 
      @else
              <option value="{{$book->id}}">{{$book->title}}</option> 
      @endif
    @endforeach
            </select>
        </div>
    </div>
  </form>
  </div>
</div>
<form id="form-normal">
    <table class="table table-striped">
@foreach ($words as $word)
@if($word->tag=='normal')
      <tr class="word-{{$word->id}}">
        <td class="checkbox-td">
          <input class="word-checkbox" checked type="checkbox" value="{{$word->id}}">
        </td>
        <td class="word-td">
            {{$word->word}}
        </td>
        <td class="state-td">
        <select class="word-state-{{$word->id}} form-control">
@if($word->state=='preview')
          <option selected value="preview">待预习</option>
@else
          <option value="preview">待预习</option>
@endif
@if($word->state=='review')
          <option selected value="review">待复习</option>
@else
          <option value="review">待复习</option>
@endif
@if($word->state=='end')
          <option selected value="end">完全掌握</option>
@else
          <option value="end">完全掌握</option>
@endif
@if($word->state=='none')
          <option value="none">下次再背</option>
@else
          <option value="none">下次再背</option>
@endif
        </select>
        </td>
        <td class="tag-td">
        <select class="word-tag-{{$word->id}} form-control">
@if($word->tag=='normal')
           <option selected value="normal">重点</option>
@else
           <option value="normal">重点</option>
@endif
@if($word->tag=='easy')
           <option selected value="easy">简单</option>
@else
           <option value="easy">简单</option>
@endif
@if($word->tag=='rare')
           <option selected value="rare">生僻</option>
@else
           <option value="rare">生僻</option>
@endif
        </select>
        </td>
        <td class="detail-td">
          <a data-wid='{{$word->id}}' class="get-word-detail">详情</a>
        </td>
        <td class="delete-td">
          <a class="word-del-{{$word->id}}">删除</a>
        </td>
      </tr>
@endif
@endforeach
    </table>
</form>
</div>
<div role="tabpanel" class="tab-pane" id="panel-easy">

    <div class="checkbox pull-left">
      <label>
        <input class="checkall" checked type="checkbox">全选
      </label>
    </div>

    <a class="advanced-select pull-left" style="margin:10px 20px; margin-right:30px; display:block;">高级筛选<span class="glyphicon glyphicon-chevron-down"></span></a>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        状态标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-preview">待预习</a></li>
        <li><a class="massive-review">待复习</a></li>
        <li><a class="massive-end">完全掌握</a></li>
        <li><a class="massive-none">下次再背</a></li>
      </ul>
    </div>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        难度标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-easy">简单</a></li>
        <li><a class="massive-normal">重点</a></li>
        <li><a class="massive-rare">生僻</a></li>
      </ul>
    </div>
 
    <a class="massive-discard btn btn-danger pull-left">删除</a>
 
    <button  class="page-refresh hidden-sm btn btn-default" style="margin-left:60px;">
        <span class="glyphicon glyphicon-refresh"></span>
    </button>

    <div class="clearfix" style="margin-bottom:20px;"></div>

@if($selected_book_id)
<div class="advanced-select-row row" style="display:block;">
@else
<div class="advanced-select-row row" style="display:none;">
@endif
  <div class="col-xs-12">
  <form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="book-select" class="col-sm-3 control-label">选择书籍 :</label>
        <div class="col-sm-9">
            <select name="book-select" class="book-select form-control">
              <option value="">所有</option>
    @foreach ($user_books as $book)
      @if($book->id==$selected_book_id)
              <option selected value="{{$book->id}}">{{$book->title}}</option> 
      @else
              <option value="{{$book->id}}">{{$book->title}}</option> 
      @endif
    @endforeach
            </select>
        </div>
    </div>
  </form>
  </div>
</div>
<form id="form-easy">
    <table class="table table-striped">
@foreach ($words as $word)
@if($word->tag=='easy')
      <tr class="word-{{$word->id}}">
        <td class="checkbox-td">
          <input class="word-checkbox" checked type="checkbox" value="{{$word->id}}">
        </td>
        <td class="word-td">
            {{$word->word}}
        </td>
        <td class="state-td">
        <select class="word-state-{{$word->id}} form-control">
@if($word->state=='preview')
          <option selected value="preview">待预习</option>
@else
          <option value="preview">待预习</option>
@endif
@if($word->state=='review')
          <option selected value="review">待复习</option>
@else
          <option value="review">待复习</option>
@endif
@if($word->state=='end')
          <option selected value="end">完全掌握</option>
@else
          <option value="end">完全掌握</option>
@endif
@if($word->state=='none')
          <option value="none">下次再背</option>
@else
          <option value="none">下次再背</option>
@endif
        </select>
        </td>
        <td class="tag-td">
        <select class="word-tag-{{$word->id}} form-control">
@if($word->tag=='normal')
           <option selected value="normal">重点</option>
@else
           <option value="normal">重点</option>
@endif
@if($word->tag=='easy')
           <option selected value="easy">简单</option>
@else
           <option value="easy">简单</option>
@endif
@if($word->tag=='rare')
           <option selected value="rare">生僻</option>
@else
           <option value="rare">生僻</option>
@endif
        </select>
        </td>
        <td class="detail-td">
          <a data-wid='{{$word->id}}' class="get-word-detail">详情</a>
        </td>
        <td class="delete-td">
          <a class="word-del-{{$word->id}}">删除</a>
        </td>
      </tr>
@endif
@endforeach
    </table>
</form>
</div>
<div role="tabpanel" class="tab-pane" id="panel-rare">

    <div class="checkbox pull-left">
      <label>
        <input class="checkall" checked type="checkbox">全选
      </label>
    </div>

    <a class="advanced-select pull-left" style="margin:10px 20px; margin-right:30px; display:block;">高级筛选<span class="glyphicon glyphicon-chevron-down"></span></a>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        状态标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-preview">待预习</a></li>
        <li><a class="massive-review">待复习</a></li>
        <li><a class="massive-end">完全掌握</a></li>
        <li><a class="massive-none">下次再背</a></li>
      </ul>
    </div>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        难度标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-easy">简单</a></li>
        <li><a class="massive-normal">重点</a></li>
        <li><a class="massive-rare">生僻</a></li>
      </ul>
    </div>
 
    <a class="massive-discard btn btn-danger pull-left">删除</a>
 
    <button  class="page-refresh hidden-sm btn btn-default" style="margin-left:60px;">
        <span class="glyphicon glyphicon-refresh"></span>
    </button>

    <div class="clearfix" style="margin-bottom:20px;"></div>

@if($selected_book_id)
<div class="advanced-select-row row" style="display:block;">
@else
<div class="advanced-select-row row" style="display:none;">
@endif
  <div class="col-xs-12">
  <form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="book-select" class="col-sm-3 control-label">选择书籍 :</label>
        <div class="col-sm-9">
            <select name="book-select" class="book-select form-control">
              <option value="">所有</option>
    @foreach ($user_books as $book)
      @if($book->id==$selected_book_id)
              <option selected value="{{$book->id}}">{{$book->title}}</option> 
      @else
              <option value="{{$book->id}}">{{$book->title}}</option> 
      @endif
    @endforeach
            </select>
        </div>
    </div>
  </form>
  </div>
</div>
<form id="form-rare">
    <table class="table table-striped">
@foreach ($words as $word)
@if($word->tag=='rare')
      <tr class="word-{{$word->id}}">
        <td class="checkbox-td">
          <input class="word-checkbox" checked type="checkbox" value="{{$word->id}}">
        </td>
        <td class="word-td">
            {{$word->word}}
        </td>
        <td class="state-td">
        <select class="word-state-{{$word->id}} form-control">
@if($word->state=='preview')
          <option selected value="preview">待预习</option>
@else
          <option value="preview">待预习</option>
@endif
@if($word->state=='review')
          <option selected value="review">待复习</option>
@else
          <option value="review">待复习</option>
@endif
@if($word->state=='end')
          <option selected value="end">完全掌握</option>
@else
          <option value="end">完全掌握</option>
@endif
@if($word->state=='none')
          <option value="none">下次再背</option>
@else
          <option value="none">下次再背</option>
@endif
        </select>
        </td>
        <td class="tag-td">
        <select class="word-tag-{{$word->id}} form-control">
@if($word->tag=='normal')
           <option selected value="normal">重点</option>
@else
           <option value="normal">重点</option>
@endif
@if($word->tag=='easy')
           <option selected value="easy">简单</option>
@else
           <option value="easy">简单</option>
@endif
@if($word->tag=='rare')
           <option selected value="rare">生僻</option>
@else
           <option value="rare">生僻</option>
@endif
        </select>
        </td>
        <td class="detail-td">
          <a data-wid='{{$word->id}}' class="get-word-detail">详情</a>
        </td>
        <td class="delete-td">
          <a class="word-del-{{$word->id}}">删除</a>
        </td>
      </tr>
@endif
@endforeach
    </table>
</form>
</div>
<div role="tabpanel" class="tab-pane" id="panel-discard">

    <div class="checkbox pull-left">
      <label>
        <input class="checkall" checked type="checkbox">全选
      </label>
    </div>

    <a class="advanced-select pull-left" style="margin:10px 20px; margin-right:30px; display:block;">高级筛选<span class="glyphicon glyphicon-chevron-down"></span></a>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
        状态标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-preview">待预习</a></li>
        <li><a class="massive-review">待复习</a></li>
        <li><a class="massive-end">完全掌握</a></li>
        <li><a class="massive-none">下次再背</a></li>
      </ul>
    </div>

    <div class="btn-group pull-left" style="margin-right:20px;">
      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
        难度标记为 <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a class="massive-easy">简单</a></li>
        <li><a class="massive-normal">重点</a></li>
        <li><a class="massive-rare">生僻</a></li>
      </ul>
    </div>
 
    <a class="massive-discard btn btn-danger pull-left">删除</a>
 
    <button  class="page-refresh hidden-sm btn btn-default" style="margin-left:60px;">
        <span class="glyphicon glyphicon-refresh"></span>
    </button>

    <div class="clearfix" style="margin-bottom:20px;"></div>

@if($selected_book_id)
<div class="advanced-select-row row" style="display:block;">
@else
<div class="advanced-select-row row" style="display:none;">
@endif
  <div class="col-xs-12">
  <form class="form-horizontal" role="form">
    <div class="form-group">
        <label for="book-select" class="col-sm-3 control-label">选择书籍 :</label>
        <div class="col-sm-9">
            <select name="book-select" class="book-select form-control">
              <option value="">所有</option>
    @foreach ($user_books as $book)
      @if($book->id==$selected_book_id)
              <option selected value="{{$book->id}}">{{$book->title}}</option> 
      @else
              <option value="{{$book->id}}">{{$book->title}}</option> 
      @endif
    @endforeach
            </select>
        </div>
    </div>
  </form>
  </div>
</div>
<form id="form-discard">
    <table class="table table-striped">
@foreach ($words as $word)
@if($word->state=='discard')
      <tr class="word-{{$word->id}}">
        <td class="checkbox-td">
          <input class="word-checkbox" checked type="checkbox" value="{{$word->id}}">
        </td>
        <td class="word-td">
            {{$word->word}}
        </td>
        <td class="state-td">
        <select class="word-state-{{$word->id}} form-control">
@if($word->state=='preview')
          <option selected value="preview">待预习</option>
@else
          <option value="preview">待预习</option>
@endif
@if($word->state=='review')
          <option selected value="review">待复习</option>
@else
          <option value="review">待复习</option>
@endif
@if($word->state=='end')
          <option selected value="end">完全掌握</option>
@else
          <option value="end">完全掌握</option>
@endif
@if($word->state=='none')
          <option value="none">下次再背</option>
@else
          <option value="none">下次再背</option>
@endif
        </select>
        </td>
        <td class="tag-td">
        <select class="word-tag-{{$word->id}} form-control">
@if($word->tag=='normal')
           <option selected value="normal">重点</option>
@else
           <option value="normal">重点</option>
@endif
@if($word->tag=='easy')
           <option selected value="easy">简单</option>
@else
           <option value="easy">简单</option>
@endif
@if($word->tag=='rare')
           <option selected value="rare">生僻</option>
@else
           <option value="rare">生僻</option>
@endif
        </select>
        </td>
        <td class="detail-td">
          <a data-wid='{{$word->id}}' class="get-word-detail">详情</a>
        </td>
        <td class="delete-td">
          <a class="word-del-{{$word->id}}">删除</a>
        </td>
      </tr>
@endif
@endforeach
    </table>
</form>
</div>




</div>

</div>



<div class="modal fade" id="word-detail">
</div><!-- /.modal -->


<div id="flashcard-step1" class="modal fade flashcard-modal">
</div><!-- /.modal -->


<div id="flashcard-step2" class="modal fade flashcard-modal">
</div><!-- /.modal -->


<div id="flashcard-step3" class="modal fade flashcard-modal">
</div><!-- /.modal -->

@stop

@section('user_script')
<script id="word-detail-temp" type="text/html">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><%=entry_key%> <small>[<%=phonetics[0].us_phonetic%>]</small></h4>
      </div>
      <div class="modal-body">
        <table class="table">
        <%for(i=0;i<explains.length;i++){%>
          <tr class="active"><td>
            <%=explains[i].ex%>
          </td></tr>
        <%}%>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</script>

<script id="flashcard-temp1" type="text/html">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        @if(count($begin_learning))
        <h4 class="modal-title">{{$learning_book->title}} <small>{{$learning_chapter->heading}}</small></h4>
        @else
        <h4 class="modal-title"> <small></small></h4>
        @endif
      </div>
      <div class="modal-body">
          <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="flashcard-content">
        <input id="word-id-hidden-step1" type="hidden" value=<%=id%>>
        <h3 class="pull-left flashcard-word"><%=word%> <small>[<%=phonetics[0].uk_phonetic%>]</small></h3>
            <div class="pull-left step-hint">
              <span class="step-bar" style="background-color:#f0ad4e;"></span>
              <span class="step-bar"></span>
              <span class="step-bar"></span>
            </div>
            <div class="flashcard-tag btn-group pull-right">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              <span class="button-value">
              <%if(tag=='normal'){%>  
              重点词 
              <%}%>
              <%if(tag=='easy'){%>  
              简单词 
              <%}%>
              <%if(tag=='rare'){%>  
              冷僻词 
              <%}%>
              </span>
              <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a class="easy-word" href="#">简单词</a></li>
                <li><a class="normal-word" href="#">重点词</a></li>
                <li><a class="rare-word" href="#">生僻词</a></li>
              </ul>
            </div>

            <div class="clearfix"></div>
            <h4 class="flashcard-sentence"><%=sentence%></h4>
            <table class="table flashcard-explain" style="visibility:hidden;">
            <%for(i=0;i<explains.length;i++){%>
              <tr class="active"><td>
               <%=explains[i].ex%>
              </td></tr>
              <%}%>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button id="explain-display" type="button" class="btn btn-primary" style="width:100%;">显示解释</button>
        <button id="unknown" type="button" class="btn btn-warning pull-left" style="width:50%; display:none;">不认识</button>
        <button id="known" type="button" class="btn btn-primary pull-right" style="width:50%; display:none;">认识</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</script>
<script id="flashcard-temp2" type="text/html">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        @if(count($begin_learning))
        <h4 class="modal-title">{{$learning_book->title}} <small>{{$learning_chapter->heading}}</small></h4>
        @else
        <h4 class="modal-title"> <small></small></h4>
        @endif
      </div>
      <div class="modal-body">
          <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="flashcard-content">
        <input type="hidden" id="word-id-hidden-step2" value=<%=id%>>
            <h3 class="pull-left flashcard-word"><%=word%> <small>[<%=phonetics[0].uk_phonetic%>]</small></h3>
            <div class="pull-left step-hint">
              <span class="step-bar" style="background-color:#f0ad4e;"></span>
              <span class="step-bar" style="background-color:#f0ad4e;"></span>
              <span class="step-bar"></span>
            </div>
            <div class="flashcard-tag btn-group pull-right">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              <span class="button-value">
              <%if(tag=='normal'){%>  
              重点词 
              <%}%>
              <%if(tag=='easy'){%>  
              简单词 
              <%}%>
              <%if(tag=='rare'){%>  
              冷僻词 
              <%}%>
              </span>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a class="easy-word" href="#">简单词</a></li>
                <li><a class="normal-word" href="#">重点词</a></li>
                <li><a class="rare-word" href="#">生僻词</a></li>
              </ul>
            </div>

            <div class="clearfix"></div>
            <table class="table table-hover flashcard-explain">
            <%for(i=0;i<selects.length;i++){%>
              <tr class="active"><td class="item-<%=answers[i]%>">
                <div class="radio">
                    <label style="width:100%; height:100%; margin:0;"><input type="radio" class="select-explain" value="<%=answers[i]%>">
                    <%=selects[i]%>
                    </label>
                </div>
              </td></tr>
            <%}%>
            </table>
        </div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-primary" id="move-on" style="display:none; width:100%;">继续</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</script>
<script id="flashcard-temp3" type="text/html">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        @if(count($begin_learning))
        <h4 class="modal-title">{{$learning_book->title}} <small>{{$learning_chapter->heading}}</small></h4>
        @else
        <h4 class="modal-title"> <small></small></h4>
        @endif
      </div>
      <div class="modal-body">
          <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
        <div class="flashcard-content">
            <input type="hidden" id="word-id-hidden-step3" value=<%=id%>>
            <h3 class="pull-left flashcard-word"><%=word%> <small>[<%=phonetics[0].uk_phonetic%>]</small></h3>
            <div class="pull-left step-hint">
              <span class="step-bar" style="background-color:#f0ad4e;"></span>
              <span class="step-bar" style="background-color:#f0ad4e;"></span>
              <span class="step-bar" style="background-color:#f0ad4e;"></span>
            </div>
            <div class="flashcard-tag btn-group pull-right">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              <span class="button-value">
              <%if(tag=='normal'){%>  
              重点词 
              <%}%>
              <%if(tag=='easy'){%>  
              简单词 
              <%}%>
              <%if(tag=='rare'){%>  
              冷僻词 
              <%}%>
              </span>
               <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a class="easy-word" href="#">简单词</a></li>
                <li><a class="normal-word" href="#">重点词</a></li>
                <li><a class="rare-word" href="#">生僻词</a></li>
              </ul>
            </div>

            <div class="clearfix"></div>
            <h4 class="flashcard-sentence"><%=sentence%></h4>
            <table class="table flashcard-explain">
            <%for(i=0;i<explains.length;i++){%>
              <tr class="active"><td>
              <%=explains[i].ex%>
              </td></tr>
            <%}%>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <div id="timer" class="pie degree">
          <span class="block"></span>
          <span id="time">0</span>
        </div>
        <button id="unknown-step3" type="button" class="btn btn-warning pull-left" style="width:50%; display:none;">不认识</button>
        <button id="known-step3" type="button" class="btn btn-primary pull-right" style="width:50%; display:none;">认识</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</script>
<script src="/js/flashcard.js" id="flashcard-js">
</script>
<script>
$('#preview-chapter-selector .belongto-'+$('#preview-book-selector').val()).css("display","block");
$('#preview-book-selector').change(function(){
    book_id = $(this).val();
    $('#preview-chapter-selector option').css("display","none");
    $('#preview-chapter-selector .belongto-'+book_id).css("display","block");
});

$('#download-all').click(function(e){
    e.preventDefault();
    $.get('/user/download/all');
});

$('#begin-preview').click(function(e){
    e.preventDefault();
    var bid = $('#preview-book-selector').val();
    var cid = $('#preview-chapter-selector').val();
    $.post('/ajax/word/start_learn/preview',{bid:bid,cid:cid},function(){
        nextWord(bid);
        $('.flashcard-modal').on('hidden.bs.modal',function(e){
            if(!dismiss)
              nextWord(bid);
            else
                $(this).off('hidden.bs.modal');
        });
    });
});
$('#begin-review').click(function(e){
    e.preventDefault();
    var bid = $('#review-book-selector').val();
    $.post('/ajax/word/start_learn/review',{bid:bid},function(){
        nextWord(bid);
        $('.flashcard-modal').on('hidden.bs.modal',function(e){
            if(!dismiss)
              nextWord(bid);
            else
                $(this).off('hidden.bs.modal');
        });
    });
});
</script>
<script>
@if(count($begin_learning))
nextWord({{$learning_book->id}});
$('.flashcard-modal').on('hidden.bs.modal',function(e){
    if(!dismiss)
      nextWord({{$learning_book->id}});
    else
        $(this).off('hidden.bs.modal');
});
@endif
</script>

<script>

$('.checkall').click(function(){
    if($(this).is(":checked"))
    {
        $('.word-checkbox').prop("checked",true);
    }
    else
    {
        $('.word-checkbox').prop("checked",false);
    }
});

</script>
<script>
$('.advanced-select').click(function(){
    if($('.advanced-select-row').css("display")=="none"){
      $('.advanced-select-row').css("display","block");
    }
    else{
      $('.advanced-select-row').css("display","none");
    }
});
</script>
<script>
$('.get-word-detail').click(function(){
    $.get('/ajax/word/get_detail?wid='+$(this).attr('data-wid'),function(data){
        var html = template('word-detail-temp',data);
        $('#word-detail').html(html);
        $('#word-detail').modal('show');
    });
});
</script>

<script>
$('#tab-{{$tab_display}}').addClass("active");
$('#panel-{{$tab_display}}').addClass("active");
</script>

<script>
$('.book-select').change(function(){
    $(window.location).attr("href","/user/wordbook?bid="+$(this).val());
});
</script>


<script>
@foreach ($words as $word)
$('.word-state-{{$word->id}}').change(function(){
    $.post('/ajax/word/set_state', {
            wid:{{$word->id}},
            state:$(this).val()
        },function(data){
    });
});

$('.word-tag-{{$word->id}}').change(function(){
    $.post('/ajax/word/set_tag', {
            wid:{{$word->id}},
            tag:$(this).val()
        },function(){
    });
});

$('.word-del-{{$word->id}}').click(function(){
    $.post('/ajax/word/set_state',{
            wid:{{$word->id}},
            state:'discard'
        },function(){
        $('.word-{{$word->id}}').css("display","none");
    });
});
@endforeach
</script>

<script>

$('.massive-preview').click(function(){
    var words_selected = [];
    $('.tab-pane.active .word-checkbox:checkbox:checked').each(function(i){
        words_selected[i] = $(this).val();
    }); 
    $.post('/ajax/word/set_many_states',{
            'words_select[]':words_selected,
            state:'preview'
            },function(){
    });
});
$('.massive-review').click(function(){
    var words_selected = [];
    $('.tab-pane.active .word-checkbox:checkbox:checked').each(function(i){
        words_selected[i] = $(this).val();
    }); 
    $.post('/ajax/word/set_many_states',{
            'words_selected[]':words_selected,
            state:'review'
            },function(){
    });
});

$('.massive-end').click(function(){
    var words_selected = [];
    $('.tab-pane.active .word-checkbox:checkbox:checked').each(function(i){
        words_selected[i] = $(this).val();
    }); 
    $.post('/ajax/word/set_many_states',{
            'words_selected[]':words_selected,
            state:'end'
            },function(){
    });
});

$('.massive-none').click(function(){
    var words_selected = [];
    $('.tab-pane.active .word-checkbox:checkbox:checked').each(function(i){
        words_selected[i] = $(this).val();
    }); 
    $.post('/ajax/word/set_many_states',{
            'words_selected[]':words_selected,
            state:'none'
            },function(){
    });
});

$('.massive-discard').click(function(){
    var words_selected = [];
    $('.tab-pane.active .word-checkbox:checkbox:checked').each(function(i){
        words_selected[i] = $(this).val();
    }); 
    $.post('/ajax/word/set_many_states',{
            'words_selected[]':words_selected,
            state:'discard'
            },function(){
    });
});

$('.massive-easy').click(function(){
    var words_selected = [];
    $('.tab-pane.active .word-checkbox:checkbox:checked').each(function(i){
        words_selected[i] = $(this).val();
    }); 
    $.post('/ajax/word/set_many_tags',{
            'words_selected[]':words_selected,
            tag:'easy'
            },function(){
    });
});

$('.massive-normal').click(function(){
    var words_selected = [];
    $('.tab-pane.active .word-checkbox:checkbox:checked').each(function(i){
        words_selected[i] = $(this).val();
    }); 
    $.post('/ajax/word/set_many_tags',{
            'words_selected[]':words_selected,
            tag:'normal'
            },function(){
    });
});

$('.massive-rare').click(function(){
    var words_selected = [];
    $('.tab-pane.active .word-checkbox:checkbox:checked').each(function(i){
        words_selected[i] = $(this).val();
    }); 
    $.post('/ajax/word/set_many_tags',{
            'words_selected[]':words_selected,
            tag:'rare'
            },function(){
    });
});
</script>

<script>
$('.page-refresh').click(function(){
    $(window.location).attr("href","/user/wordbook?bid="+$('.book-select').val());    
});
</script>

@stop
