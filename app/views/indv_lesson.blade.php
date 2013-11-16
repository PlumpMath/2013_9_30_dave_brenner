@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Dashboard', 'icon' => 'dashboard', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Dashboard'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Your Account'])
		<div class="box box-pad-0">
			<a href="{{ $your_info }}">Your info</a>
		</div>
		<div class="box box-pad-0">
		</div>
	</div>
	<div class="box-4 bg-0 border-left">
		@include('modules.section_divide', ['name' => 'Current Classes'])
		@include('modules.lesson-2', $class)
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop