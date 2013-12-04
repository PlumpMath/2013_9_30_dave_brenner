@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Updated!', 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Updated!'])
<div class="box box-pad-0 measure center">{{ $msg }} has been updated.</div>
<div class="box box-pad-0 measure center">Return to <a href="{{ $dashboard }}">the dashboard?</a></div>
@stop
