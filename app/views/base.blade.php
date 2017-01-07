<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/packages/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/packages/css-loaders/css/load5.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    @yield('style')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top navbar-normal" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li id="index_nav"><a href="/">首页</a></li>
            <li id="bookstore_nav"><a href="/bookstore">书库</a></li>
            <li id="bookshelf_nav"><a href="/user/bookshelf">我的藏书架</a></li>
            <li id="wordbook_nav"><a href="/user/wordbook">我的单词本</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            @if(! Auth::check())
            <li><a href="{{route('login')}}">登陆</a></li>
            <li><a href="{{route('register')}}">注册</a></li>
            @else
            <li><a href="/user/dashboard">{{Auth::user()->username}}</a></li>
            <li><a href="{{route('logoutHandle')}}">登出</a></li>
            @endif
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    
   @yield('header')

    @yield('content')
    <div class="container footer">
      <hr>
      @copyright
    </div>

  <div id="waitting-cover" class="modal-backdrop fade in" style="bottom:0px; padding-top:200px; display:none;">
    <div class="load5 center-block" style="margin-top:-12.5px;">
      <div class="loader"></div>
    </div>
  </div>

@if(Session::has('message'))
   <div class="alert alert-info alert-dismissible" role="alert" style="text-align:center; position:fixed; bottom:0; left:0; right:0; margin:0;">
     <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
   {{Session::pull('message');}}
   </div>
@endif


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/packages/bootstrap/js/bootstrap.min.js"></script>
    <!-- art template -->
    <script src="/packages/artTemplate/dist/template-native.js"></script>
    <script src="/packages/jQuery.dotdotdot/src/js/jquery.dotdotdot.min.js"></script>
    <script>$('.ellipsis').dotdotdot({});</script>

@if(Route::currentRouteName()=="index")
<script>$('#index_nav').addClass("active");</script>
@endif
@if(Route::currentRouteName()=="bookshelf")
<script>$('#bookshelf_nav').addClass("active");</script>
@endif
@if(Route::currentRouteName()=="bookstore")
<script>$('#bookstore_nav').addClass("active");</script>
@endif
@if(Route::currentRouteName()=="wordbook")
<script>$('#wordbook_nav').addClass("active");</script>
@endif
    @yield('script')
  </body>
</html>

