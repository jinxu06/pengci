@extends('emails.emailbase')

@section('header')
<h2>邮箱确认</h2>
@stop

@section('body')
<p>欢迎来到Pengci网，请点击一下链接完成注册:<a href="{{ URL::to('register/verify/' . $confirmation_code) }}">{{ URL::to('register/verify/' . $confirmation_code) }}</a>。</p>
<p>如果链接不能点击，您可以将链接地址复制到浏览器的地址栏中。<p>
<p>如果还有问题，能可以发邮件到 help@pengci.me，我们会尽快为您解决问题。</p>
<p>好啦，现在您就可以开始使用啦！</p>
@stop

@section('footer')
<h3>Pengci.Inc</h3>
@stop
