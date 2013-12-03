@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Edit Your Child\'s Info', 'icon' => 'edit', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Edit Your Child\'s Info'])
<div class="box bg-1">
	<div class="box measure bg-0 border-left border-bottom-0">
		<div class="box box-pad-0 fg-1 border-0">Current</div>
		{{ Form::open(['url' => $verify]) }}
		<div class="box box-pad-0">
			@foreach($fields as $field)
				@include('modules.input-0', $field)
			@endforeach
			@include('modules.menu-2', $gender_field)
			@include('modules.input-1', $check)
			<div class="box box-pad-0">If you need to change your child's birthday, please call us at: <span class="bold">631-776-8242</span></div>
		</div>
		@include('modules.button-0', ['text' => 'OK'])
		{{ Form::close() }}
	</div>
</div>
@stop
