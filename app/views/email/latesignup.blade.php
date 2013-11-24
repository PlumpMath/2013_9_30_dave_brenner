@extends('layouts.email')

@section('content')
<h1 style="display: block; font-family: 'Open Sans'; font-size: 26px; font-style: normal; font-weight: bold; line-height: 100%; letter-spacing: normal; margin: 0px 0px 10px; text-align: left; color: rgb(82, 82, 82);">Hi, {{{ $user_name }}}</h1>
<h3 style="display: block; font-family: 'Open Sans'; font-size: 16px; font-style: italic; font-weight: normal; line-height: 100%; letter-spacing: normal; margin: 0px 0px 10px; text-align: left; color: rgb(149, 149, 149);">Thanks for your interest in the {{ $activity }} program.</h3>
Clicking the link below will take you to our website so you can register {{ $child }} for class. Don't forget, your 24 hour window closes on {{ $time }}. After this time, your spot is no longer held and the link will not work.<br/>Thank you!
@stop
