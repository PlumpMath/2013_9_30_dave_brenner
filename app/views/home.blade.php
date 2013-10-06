@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Home', 'icon' => 'home', 'user_name' => $user_name])
<div class="box box-banner-0 center img-0">
	<div class="type-0 bold fg-2 clear-under">Jumpstart a healthy lifestyle</div>
	<div class="type-3 fg-2 measure">Our programs <span class="fg-3">bring children together</span> to play and learn about the value of <span class="fg-3">staying&nbsp;active</span> and <span class="fg-3">living&nbsp;healthy</span></div>
</div>
<div class="box box-pad-0">
	<div class="box-3">
		<div class="box box-pad-0">
			<div class="type-1 center">New here?</div>
		</div>
		<div class="box box-pad-0">
			<div class="type-3 fg-1 measure">Our programs are offered in over 6 locations across Long Island, and are taught by skilled professionals.</div>
		</div>
		@include('modules.button-1', ['text' => 'Sign up'])
	</div>
	<div class="box-3 center border-left">
		<div class="box box-pad-0">
			<div class="type-1">Sign in</div>
		</div>
		{{ Form::open(['url' => '/log/in']) }}
		@foreach ($fields as $field)
		@include('modules.input-0', $field)
		@endforeach
		@include('modules.button-0', ['text' => 'Sign in'])
		{{ Form::close() }}
	</div>
</div>
@stop
