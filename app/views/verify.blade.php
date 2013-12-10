@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Verify Your Account', 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Verify Your Account'])
<div class="box box-pad-0 measure center">For your security, we have sent an email to {{{ $email }}}.<br/> Please open your email and follow the simple directions to complete your verification.<br/>Then, we can continue with your registration. Thanks!</div>
<div class="box box-pad-0 measure center">IMPORTANT<br/>If you do not receive our verification email, <a href="{{ $another_email }}">click here</a> to have another sent.<br/>If you still do not receive an email, look in your spam/Junk mail folder.</div>
@stop
