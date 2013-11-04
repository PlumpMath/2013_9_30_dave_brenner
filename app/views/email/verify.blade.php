@extends('layouts.email')

@section('content')
<h1 style="display: block; font-family: 'Open Sans'; font-size: 26px; font-style: normal; font-weight: bold; line-height: 100%; letter-spacing: normal; margin: 0px 0px 10px; text-align: left; color: rgb(82, 82, 82);">Hi, {{{ $user_name }}}</h1>
<h3 style="display: block; font-family: 'Open Sans'; font-size: 16px; font-style: italic; font-weight: normal; line-height: 100%; letter-spacing: normal; margin: 0px 0px 10px; text-align: left; color: rgb(149, 149, 149);">
This is your verification email.  To verify your account with us, just click the link below.  Easy right? </h3>
Btw: if nothing happens when you click the link, please copy and paste the link into the address bar of your browser and press enter on your keyboard. This should take you to our account activation page. If you still have trouble, call us at 631-776-8242 so we can help you. Thanks!
<a href="{{ $link }}">Click to activate your account</a>
@stop
