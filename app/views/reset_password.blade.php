@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Account Management', 'icon' => 'key', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Account Management: Password Reset'])
<div class="box box-pad-0 measure">An email has been sent to your account. Follow its instructions to reset your account's password.</div>
@stop
