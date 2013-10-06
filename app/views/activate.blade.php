@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Home', 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Account Activated!'])
<div class="box box-pad-0 measure center">We&rsquo;re redirecting you to the homepage in <br/><span class="countdown-seconds">10 seconds</span> <span class="countdown-ellipsis">...</span></div>
<div class="box box-pad-0 measure center">Alternatively, you could click <a href="{{ $home }}">here</a> to go there now.</a></div>
@stop
