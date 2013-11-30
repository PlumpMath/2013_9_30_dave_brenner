@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Home', 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Account Activated!'])
<div class="box box-pad-0 measure center">Hi {{{ $user_name }}}</div>
<div class="box box-pad-0 measure center">OK, your account is now verified. If you click on the link below, you can continue where you left off with your registration. Thanks!</div>
<div class="box box-pad-0 measure center"><a href="{{ $home }}">Continue to register your children</a></a></div>
@stop
