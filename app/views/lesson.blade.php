@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Lesson Calendar', 'icon' => 'calendar', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Lesson Calendar'])
<div class="box bg-1">
	<div class="box measure bg-0 border-left border-bottom-0">
		<div class="box box-pad-0 fg-1 border-0">Calendar</div>
		<div class="box box-pad-0 center">
			@include('modules.calendar', ['calendar' => $calendar])
		</div>
		@include('modules.calendar-key')
	</div>
</div>
<div class="box box-pad-0 bg-0"></div>
@stop