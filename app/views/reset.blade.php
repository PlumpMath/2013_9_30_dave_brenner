@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Account Management', 'icon' => 'key', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Account Management'])
<div class="box box-pad-0 measure"><span class="bold">I forgot my password.</span><br /><br />Enter the email you created the account with below:</div>
{{ Form::open(['url' => URL::to('/account/password'), 'method' => 'GET']) }}
<div class="box center">
@include('modules.input-0', ['name' => 'email', 'type' => 'text', 'label' => 'Email Address'])
</div>
<div class="box center">
@include('modules.button-0', ['text' => 'Reset'])
</div>
{{ Form::close() }}
<div class="box box-pad-0 measure"><span class="bold">I forgot my username.</span><br /><br />Call us at (555) 555-5555</div>
<div class="box box-pad-0 bg-0"></div>
@stop
