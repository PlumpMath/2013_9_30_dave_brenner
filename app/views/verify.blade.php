@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Home', 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Verify'])
<div class="box box-pad-0 measure center">We&rsquo;ve sent you an email containing a link to activate your account. It may take a few minutes for the email to arrive.</div>
<div class="box box-pad-0 measure center">Would you like us to <a href="{{ $another_email }}">send another?</a></div>
@stop
