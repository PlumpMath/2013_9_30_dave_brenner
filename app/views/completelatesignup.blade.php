@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Pending Late Sign Up', 'icon' => 'user', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Pending Late Sign Up'])
<div class="box box-pad-0 measure center">You have a late sign up pending for {{{ $child_name }}}!</div>
<div class="box box-pad-0 measure center">The class you selected with us over the phone has been added to your order. Would you like to <a href="{{ $review }}">check out your order</a>, or <a href="{{ $enroll }}">pick more classes</a>?</div>
@stop
