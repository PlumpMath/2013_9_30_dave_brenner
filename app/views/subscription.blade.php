@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Subscription', 'icon' => 'edit', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Subscription'])
<div class="box bg-1">
	<div class="box measure bg-0 border-left border-bottom-0">
		<div class="box box-pad-0 fg-1 border-0">Current</div>
		{{ Form::open(['url' => $verify]) }}
		<div class="box box-pad-0 bg-0 border-bottom-0">@include('modules.input-1', ['name' => 'subscribed', 'label' => 'I would like to receive emails from myafterschoolprograms.com'])</div>
		@include('modules.button-0', ['text' => 'Change subscription status'])
		{{ Form::close() }}
	</div>
</div>
@stop
