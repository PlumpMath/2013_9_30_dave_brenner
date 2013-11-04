@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Home', 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Verify'])
<div class="box box-pad-0 measure center">For your security, we now need to verify your account. An email has been sent to {{{ $email }}}. Please open your email and follow the directions.  After this quick verification process, we can continue with your registration. Thanks!</div>
<div class="box box-pad-0 measure center">Would you like us to <a href="{{ $another_email }}">send another?</a></div>
@stop
