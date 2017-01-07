@extends('emails.emailbase')

@section('header')
<h2>密码重置</h2>
@stop

@section('body')
<p>您好，欢迎使用碰瓷儿。在这里您能够获得最好的英语阅读体验。</p>
<p>您刚在网站上提出了重置密码的申请，如果不是您本人行为，请忽略这封邮件。您只需要遵照下面的步骤就能完成密码重置。</p>
<p>请点击下面的链接来完成密码重置:<a href="{{ URL::to('password/reset',array($token)) }}">{{ URL::to('password/reset',array($token)) }}</a>,这个链接会在{{ Config::get('auth.reminder.expire',60) }}分钟内失效。</p>
<p>如果该链接无法点击请复制以上到您的浏览器地址栏。</p>
<p>如果还有问题，请发送邮件到help@pengci.me,我们会尽快为您解决问题。</p>
<p>本邮件为自动发送，请勿直接回复。</p>
@stop

@section('footer')
  <h3>Pengci.Inc</h3>
@stop
