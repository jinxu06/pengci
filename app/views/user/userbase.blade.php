@extends('base')

@section('header')
<div class="container-header">
  <div class="header-heading">
    <h4>个人主页</h4>
  </div>
  <div class="header-body">
      <div id="subnav">
        <ul class="nav nav-pills nav-collection" role="tablist">
          <li id="dashboard_subnav" role="presentation"><a href="/user/dashboard">个人信息</a></li>
          <li id="bookshelf_subnav" role="presentation"><a href="/user/bookshelf">已收藏图书</a></li>
          <li id="wordbook_subnav" role="presentation"><a href="/user/wordbook">我的单词本</a></li>
        </ul>
      </div>
  </div>
</div>
@stop

@section('content')
  @yield('user_content')
@stop

@section('script')
@if(Route::currentRouteName()=="dashboard")
<script>$('#dashboard_subnav').addClass("active");</script>
@endif
@if(Route::currentRouteName()=="bookshelf")
<script>$('#bookshelf_subnav').addClass("active");</script>
@endif
@if(Route::currentRouteName()=="wordbook")
<script>$('#wordbook_subnav').addClass("active");</script>
@endif
  @yield('user_script')
@stop

