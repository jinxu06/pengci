<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/packages/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    <link href="/packages/css-loaders/css/load5.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="reading reading-context">
    <div class="reading reading-toolbar btn-group-vertical">
      <button id="back" type="button" class="back-to-bookpage btn btn-default" data-toggle="tooltip" title="返回"><span class="glyphicon glyphicon-arrow-left"></span></button>
 <!--     <button id="setting" type="button" class="btn btn-default" data-toggle="tooltip" title="设置"><span class="glyphicon glyphicon-cog"></span></button>-->
      <button id="pick-book" type="button" class="btn btn-default" data-toggle="tooltip" title="到藏书架选书"><span class="glyphicon glyphicon-book"></span></button>
    </div>
    <div class="reading reading-panel center-block" style="padding:40px;">
    <div class="reading-bookmark"></div>
    <div class="article" id="area" style="width:100%; height:100%;">
    </div>
    <div id="content-list" style="height:100%; width:100%; display:none; overflow:scroll;">
@foreach ($chapters as $chapter)
      <a class="text-center" id='order{{$chapter->playorder}}'><h4>{{$chapter->heading}}</h4></a>
@endforeach
    </div>
    <div id="bookmark-list" style="height:100%; width:100%; display:none; overflow:scroll;">
@foreach ($bookmarks as $bookmark)
      <a class="text-center" id='bookmark{{$bookmark->id}}'><h4>{{$bookmark->name}}</h4></a>
@endforeach
    </div>
    <div class="reading reading-toolbar btn-group-vertical">
      <button id="contentlist" type="button" class="btn btn-default" data-toggle="tooltip" title="目录"><span class="glyphicon glyphicon-th-list"></span></button>
      <button id="bookmark" type="button" class="btn btn-default" data-toggle="tooltip" title="书签"><span class="glyphicon glyphicon-bookmark"></span></button>
      <button id="search" type="button" class="btn btn-default" data-toggle="popover tooltip" title="查词" data-trigger="manual"><span class="glyphicon glyphicon-search"></span></button>
      <button id="fake" type="button" class="btn btn-default" data-toggle="popover" title="查词" data-content="This is the explanation" data-trigger="manual" style="visibility:hidden; position:relative; bottom:30px;"><span class="glyphicon glyphicon-search"></span></button>
    </div>
    <div class="reading reading-pagination btn-group-vertical btn-group-lg">
      <button id="prevpage" type="button" class="btn btn-default" data-toggle="tooltip" title="上一页" onclick="Book.prevPage();"><span class="glyphicon glyphicon-circle-arrow-left"></span></button>
      <button id="nextpage" type="button" class="btn btn-default" data-toggle="tooltip" title="下一页" onclick="Book.nextPage();"><span class="glyphicon glyphicon-circle-arrow-right"></span></button>
    </div>
    </div>
   
  </div>

    <script id="bookmark-list-temp" type="text/html">
      <%for(i=0;i<bookmarks.length;i++){%> 
        <a class="text-center" id='bookmark<%=bookmarks[i].id%>' onclick='gotoBookmark("<%=bookmarks[i].bookmark%>")'><h4><%=bookmarks[i].name%></h4></a>
      <%}%>
    </script>

  <div id="waitting-cover" class="modal-backdrop fade in" style="bottom:0px; padding-top:200px; display:block;">
    <div class="load5 center-block" style="margin-top:-12.5px;">
      <div class="loader"></div>
    </div>
  </div>


<div class="modal fade" id="end-of-chapter">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">提示</h4>
      </div>
      <div class="modal-body">
        <p>已超出本章范围，建议您在阅读新的章节时返回生成单词</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">仍然继续</button>
        <button type="button" class="back-to-bookpage btn btn-primary">选取新章节</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="name-bookmark" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">为书签起个名字以便查找</h4>
      </div>
      <div class="modal-body">
        <input id="bookmark_name" type="text" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button id="save-bookmark-name" type="button" class="btn btn-primary">保存</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/packages/bootstrap/js/bootstrap.min.js"></script>
    <script src="/packages/artTemplate/dist/template-native.js"></script>
    <script src="/packages/epub.js/build/epub.min.js"></script>
    <script src="/packages/epub.js/build/libs/zip.min.js"></script>
    <script id="epub-js">
        var allow_display = false;

        EPUBJS.filePath = "/packages/epub.js/build/libs/";
        var base = "/epub/"
        var Book = ePub(base+'{{$book->epub_location}}');
        var render = Book.renderTo("area");
        @if($chapter_display)
            Book.goto('{{$chapter_display}}');
        @endif
        @if($cfi)
            Book.gotoCfi('{{$cfi}}');
        @endif
        //Book.addHeadTag('link', {'rel':'stylesheet', 'href':''});


        Book.on('book:ready',function(){
            $('#waitting-cover').css("display","none");
        });
        Book.on('renderer:chapterUnloaded',function(){
            if(allow_display)
                $('#waitting-cover').css("display","block");
            else
                $('#end-of-chapter').modal('show');

        });

        Book.on('renderer:chapterDisplayed',function(){
            $('#waitting-cover').css("display","none");
        });
        // overlay effect during book loading
        

    </script>
    <script>
      function gotoBookmark(bookmark)
      {
            allow_display = true;
            Book.displayChapter(bookmark).then(function(){
              $('#bookmark').trigger('click');
              allow_display = false;
            });
      }
      function refreshBookmarks()
      {
          $.get('/ajax/book/get_bookmarks?bid={{$book_id}}',function(data){
              var html = template('bookmark-list-temp',data);
              $('#bookmark-list').html(html);
          });
      }
    </script>
    <script>
      function queryWord()
      {
            var str = $('#query-box').val();
            $.get('api/entry?key='+str.toLowerCase(),function(data,status){
                if(!data)
                {
                    $('#fake').attr("data-original-title",str);
                    $('#fake').attr("data-content","未能找到查询结果");
                    $('#fake').popover('show');
                    return;
                }
                $('#fake').attr("data-original-title",data['entry_key']);
                var str_phonetics = ""
                var str_phonetics = "["+data['phonetics'][0]['us_phonetic']+"]";
                var str_translations = ""
                for(var i=0;i<data['translations'].length;i++)
                {
                    var str_translations = str_translations+data['translations'][i]['translation']; 
                }
                var str_explains = "<table class='table table-striped'>";
                for(var j=0;j<data['explains'].length;j++)
                {
                    var str_explains = str_explains+"<tr><td>"+data['explains'][j]['ex']+"</td></tr>"; 
                }
                str_explains = str_explains+"</table>";
                var content = "<h5>"+str_phonetics+"</h5>"+str_explains;
                $('#fake').attr("data-content",content);
                $('#fake').popover('show');
            });
            $('#search').popover('hide');
        
      }
    </script>
    <script>
      $('.back-to-bookpage').click(function(){
          $(window.location).attr('href','/bookpage/{{$book_id}}');
      });

      $('#pick-book').click(function(){
          $(window.location).attr('href','/user/bookshelf');
      });
    </script>
    <script>
      window.onbeforeunload = function(){
          $.post('/ajax/book/update_progress',{cfi:Book.getCurrentLocationCfi(),bid:{{$book_id}}});
      };
    </script>
    <script>
    function reset()
    {
        $('#contentlist').css("background-color","#e5e4db");
        $('#bookmark').css("background-color","#e5e4db");
        $('#search').css("background-color","#e5e4db");
        //button
        $('#content-list').css("display","none");
        $('#bookmark-list').css("display","none");
        $('#search').popover('hide');
        $('#area').css("display","block");
        //panel
    }
    </script>
    <script id="contentlist-js">
      $('#contentlist').click(function(){
          if($('#content-list').css("display")=="none")
          {
            reset();
            $(this).css("background-color","#f6f4ec");
            $('#area').css("display","none");
            $('#content-list').css("display","block");
          }
          else{
              reset();
          }
      });// button click effect 

    @foreach ($chapters as $chapter)
        $('#order{{$chapter->playorder}}').click(function(event){
            allow_display = true;
            event.preventDefault();
            Book.goto('{{$chapter->hyperlink}}').then(function(){
              $('#contentlist').trigger('click');
              allow_display = false;
            });
        });
    @endforeach
        // chapter link effect

    </script>
    <script id="bookmark-js">
    $('.reading-bookmark').click(function(){
        $('#name-bookmark').modal('show');
        $('#save-bookmark-name').click(function(){
            $.post('/ajax/book/add_bookmark',{cfi:Book.getCurrentLocationCfi(),bid:{{$book_id}},n:$('#bookmark_name').val()},function(){
                refreshBookmarks();
                $('#name-bookmark').modal('hide');
            });
        });
    });
    $('#bookmark').click(function(){
          if($('#bookmark-list').css("display")=="none")
          {
            reset();
            $(this).css("background-color","#f6f4ec");
            $('#area').css("display","none");
            $('#bookmark-list').css("display","block");
          }
          else{
              reset();
          }
    });



    @foreach ($bookmarks as $bookmark)
        $('#bookmark{{$bookmark->id}}').click(function(event){
            allow_display = true;
            event.preventDefault();
            Book.displayChapter('{{$bookmark->bookmark}}').then(function(){
              $('#bookmark').trigger('click');
              allow_display = false;
            });
        });
    @endforeach
    </script>
<script id="search-js">
  $('#search').css("background-color","rgb(229, 228, 219)");
  $('#search').click(function(){
      if($(this).css("background-color")=="rgb(229, 228, 219)")
      {
        $(this).css("background-color","#f6f4ec");
      }
      else{
        $(this).css("background-color","#e5e4db");
      }
  });
function hoverCSS(){
$("iframe").contents().find("span").each(function(){
    $(this).mouseover(function(){
        $(this).css("background-color","orange");
     });
    $(this).mouseout(function(){
        $(this).css("background-color","");
    });
});
}

function showEx(){
    $("iframe").contents().find("span").each(function(){
        $(this).click(function(){
            var str = $(this).text();
            $.get('api/entry?key='+str.toLowerCase(),function(data,status){
                if(!data)
                {
                    $('#fake').attr("data-original-title",str);
                    $('#fake').attr("data-content","未能找到查询结果");
                    $('#fake').popover('show');
                    return;
                }
                $('#fake').attr("data-original-title",data['entry_key']);
                var str_phonetics = ""
                var str_phonetics = "["+data['phonetics'][0]['us_phonetic']+"]";
                var str_translations = ""
                for(var i=0;i<data['translations'].length;i++)
                {
                    var str_translations = str_translations+data['translations'][i]['translation']; 
                }
                var str_explains = "<table class='table table-striped'>";
                for(var j=0;j<data['explains'].length;j++)
                {
                    var str_explains = str_explains+"<tr><td>"+data['explains'][j]['ex']+"</td></tr>"; 
                }
                str_explains = str_explains+"</table>";
                var content = "<h5>"+str_phonetics+"</h5>"+str_explains;
                $('#fake').attr("data-content",content);
                $('#fake').popover('show');
            });
        });
    });
}
$('#fake').on('shown.bs.popover',function(){
    $('#pop-dismiss').click(function(){
        $('#fake').popover('hide');
    });
});
Book.on('book:ready',hoverCSS);
Book.on('renderer:chapterDisplayed',hoverCSS);
Book.on('renderer:chapterDisplayed',showEx);
</script>
    <script>
$('#fake').popover({'container':'body','placement':'left','html':true,'template':'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title">hello</h3><div class="popover-content"></div><button id="pop-dismiss" type="button" class="btn btn-default" style="margin:5px;">关闭</button><!--<button id="pop-save" type="button" class="btn btn-success" style="margin:5px;">加入生词本</button>--></div>'});
        $('#contentlist').tooltip({'placement': 'left','container': 'body'});
        $('#bookmark').tooltip({'placement': 'left','container': 'body'});
        $('#search').popover({'container':'body','placement':'left','template':'<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-content" style="padding:0px;"></div><div class="input-group"><input id="query-box" type="text" class="form-control"><span class="input-group-btn"><button id="query-btn" class="btn btn-default" type="button" onclick="queryWord()">Go!</button></span></div></div>'});
        $('#search').click(function(){
            $('#search').popover('toggle');
        });
        
        $('#search').tooltip({'placement': 'left','container': 'body','trigger':'hover'});
        $('#prevpage').tooltip({'placement': 'left','container': 'body'});
        $('#nextpage').tooltip({'placement': 'left','container': 'body'});
        $('#back').tooltip({'placement': 'right','container': 'body'});
        $('#setting').tooltip({'placement': 'right','container': 'body'});
        $('#wordset').tooltip({'placement': 'right','container': 'body'});
    </script>
  </body>
</html>


