var words_to_learn = [];
var step = 3;
var remaining = 0;
var total = 1;
var progress = 0;
var dismiss = true;
//var words_to_learn_cache = [];
//var step_cache = 3;
//var interval = 0;
/*
function loadCache()
{
    var step_next = step%3+1;
    $.get('/ajax/word/get_batch?step='+step_next+'&bid=4',function(data){
        words_to_learn_cache = data.batch;
        step_cache = data.step;
    });
}

function getCache()
{
    if(words_to_learn_cache.length)
    {
        words_to_learn = words_to_learn_cache;
        step = step_cache;
        words_to_learn_cache = [];
        clearInterval(interval);
        showModal();
        loadCache();
    }
    if(!step)
    {
        clearInterval(interval);
    }
}*/
function nextWord(bid)
{
    if(words_to_learn.length)
    {
        showModal();
    }
    else
    {
       // interval = setInterval("getCache()",1000);
        var step_next = step%3+1;
        $.get('/ajax/word/get_batch?step='+step_next+'&bid='+bid,function(data){
            words_to_learn = data.batch;
            step = data.step;
            remaining = data.remaining;
            total = data.total;
            showModal();
        });

    }
}

function showModal()
{
    dismiss = true;
    if(step==1)
    {
        var html = template('flashcard-temp1',words_to_learn.shift());
        $('#flashcard-step1').html(html);
        step1_js();
        $('#flashcard-step1').modal('show');
    }
    else if(step==2)
    {
        var html = template('flashcard-temp2',words_to_learn.shift());
        $('#flashcard-step2').html(html);
        step2_js();
        $('#flashcard-step2').modal('show');
    }
    else if(step==3)
    {
        var html = template('flashcard-temp3',words_to_learn.shift());
        $('#flashcard-step3').html(html);
        step3_js();
        $('#flashcard-step3').modal('show');
    }
    else
    {
    }
    progress = 100-Math.round(remaining/total*100);
    $('.progress-bar').css('width',progress+'%');
}

function step1_js()
{
    $('.flashcard-tag .easy-word').click(function(){
        $.post('/ajax/word/set_tag',{wid:$('#word-id-hidden-step1').val(),tag:'easy'},function(){
            $('.flashcard-tag .button-value').html("简单词");
        });
    });
    $('.flashcard-tag .normal-word').click(function(){
        $.post('/ajax/word/set_tag',{wid:$('#word-id-hidden-step1').val(),tag:'normal'},function(){
            $('.flashcard-tag .button-value').html("重点词");
        });
    });
    $('.flashcard-tag .rare-word').click(function(){
        $.post('/ajax/word/set_tag',{wid:$('#word-id-hidden-step1').val(),tag:'rare'},function(){
            $('.flashcard-tag .button-value').html("生僻词");
        });
    });
    $('#explain-display').click(function(){
        $(this).css("display","none");
        $('#unknown').css("display","block");
        $('#known').css("display","block");
        $('#flashcard-step1 .flashcard-explain').css("visibility","visible");
        $('#unknown').click(function(){
            $.post('/ajax/word/set_step',{wid:$('#word-id-hidden-step1').val(),step:1});
            dismiss = false;
            $('.modal').modal('hide');
        });
        $('#known').click(function(){
            $.post('/ajax/word/set_step',{wid:$('#word-id-hidden-step1').val(),step:2});
            dismiss = false;
            $('.modal').modal('hide');
            remaining = remaining-1;
        });
    });
}

function step2_js()
{
    $('.flashcard-tag .easy-word').click(function(){
        $.post('/ajax/word/set_tag',{wid:$('#word-id-hidden-step2').val(),tag:'easy'},function(){
            $('.flashcard-tag .button-value').html("简单词");
        });
    });
    $('.flashcard-tag .normal-word').click(function(){
        $.post('/ajax/word/set_tag',{wid:$('#word-id-hidden-step2').val(),tag:'normal'},function(){
            $('.flashcard-tag .button-value').html("重点词");
        });
    });
    $('.flashcard-tag .rare-word').click(function(){
        $.post('/ajax/word/set_tag',{wid:$('#word-id-hidden-step2').val(),tag:'rare'},function(){
            $('.flashcard-tag .button-value').html("生僻词");
        });
    });
    $('.select-explain').click(function(){
        if($(this).val()=="yes")
        {
            $.post('/ajax/word/set_step',{wid:$('#word-id-hidden-step2').val(),step:3});
            dismiss = false;
            $('.modal').modal('hide');
            remaining = remaining-1;
        }
        else
        {
            $.post('/ajax/word/set_step',{wid:$('#word-id-hidden-step2').val(),step:1});
            dismiss = false;
            $('.select-explain').prop("disabled",true);
            $('.item-no').addClass("answer-wrong")
            $('.item-yes').addClass("answer-correct")
            $('#move-on').css("display","block");
        }
    });
    $('#move-on').click(function(){
        $('.modal').modal('hide');
        remaining = remaining+1;
    });
}

function step3_js()
{
    $('.flashcard-tag .easy-word').click(function(){
        $.post('/ajax/word/set_tag',{wid:$('#word-id-hidden-step3').val(),tag:'easy'},function(){
            $('.flashcard-tag .button-value').html("简单词");
        });
    });
    $('.flashcard-tag .normal-word').click(function(){
        $.post('/ajax/word/set_tag',{wid:$('#word-id-hidden-step3').val(),tag:'normal'},function(){
            $('.flashcard-tag .button-value').html("重点词");
        });
    });
    $('.flashcard-tag .rare-word').click(function(){
        $.post('/ajax/word/set_tag',{wid:$('#word-id-hidden-step3').val(),tag:'rare'},function(){
            $('.flashcard-tag .button-value').html("生僻词");
        });
    });
    $('#unknown-step3').click(function(){
        $.post('/ajax/word/set_step',{wid:$('#word-id-hidden-step3').val(),step:1});
        dismiss = false;
        $('.modal').modal('hide');
        remaining = remaining+2;
    });
    $('#known-step3').click(function(){
        $.post('/ajax/word/set_step',{wid:$('#word-id-hidden-step3').val(),step:4});
        dismiss = false;
        $('.modal').modal('hide');
        remaining = remaining-1;
    });

    var totaltime = 5;
    function update(percent){
        var deg;
        if(percent<(totaltime/2)){
            deg = 90 + (360*percent/totaltime);
            $('.pie').css('background-image','linear-gradient('+deg+'deg, transparent 50%, white 50%),linear-gradient(90deg, white 50%, transparent 50%)');
        } 
        else if(percent>=(totaltime/2)){
            deg = -90 + (360*percent/totaltime);
            $('.pie').css('background-image','linear-gradient('+deg+'deg, transparent 50%, #1fbba6 50%),linear-gradient(90deg, white 50%, transparent 50%)');
        }
    }
    var count = parseInt($('#time').text());
    myCounter = setInterval(function () {
        count+=1;
        $('#time').html(count);
        update(count);
        if(count==totaltime) 
        {
            clearInterval(myCounter);
            document.getElementById("timer").style.display = "none";
            document.getElementById("unknown-step3").style.display = "block";
            document.getElementById("known-step3").style.display = "block";
        }
    }, 1000);
}
