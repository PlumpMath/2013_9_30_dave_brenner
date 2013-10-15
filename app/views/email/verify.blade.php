@extends('layouts.email')

@section('content')
<h1 style="display: block; font-family: 'Open Sans'; font-size: 26px; font-style: normal; font-weight: bold; line-height: 100%; letter-spacing: normal; margin: 0px 0px 10px; text-align: left; color: rgb(82, 82, 82);">Welcome!</h1>
<h3 style="display: block; font-family: 'Open Sans'; font-size: 16px; font-style: italic; font-weight: normal; line-height: 100%; letter-spacing: normal; margin: 0px 0px 10px; text-align: left; color: rgb(149, 149, 149);"></h3>
<a href="{{ $link }}">Click to activate your account</a>
@stop
