@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Lesson', 'icon' => 'edit', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Lesson'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Progress'])
	</div>
	<div class="box-4 bg-0">
		<div class="box box-pad-0 fg-1 border-0">Calendar</div>
		<div class="box box-pad-0">
			@include('modules.calendar', ['calendar' => $calendar])
		</div>
	</div>
</div>
@stop