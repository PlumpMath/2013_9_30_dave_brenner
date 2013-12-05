@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Register', 'icon' => 'edit', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Register'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Progress'])
		@include('modules.menu-0', ['item' => 'Your Info'])
		<div class="fg-4">
		@include('modules.menu-0', ['item' => 'Your Children'])
		</div>
	</div>
	<div class="box-4 bg-0">
		<div class="box box-pad-0 fg-1 border-0">Current</div>
		{{ Form::open(['url' => $verify]) }}
		<div class="box box-pad-0">
			@foreach($fields as $field)
				@if ($field['type'] === 'form-hint')
				<div class="box box-pad-6">{{ $field['label'] }}</div>
				@else
				@include('modules.input-0', $field)
				@endif
			@endforeach
			<div class="box box-pad-0">Please enter your child's birthday as mm/dd/yyyy</div>
			@include('modules.menu-2', $gender_field)
			@include('modules.input-1', $check)
			<div class="box box-pad-0">Fields marked with <span class="fg-4">*</span> are required.</div>
		</div>
		@include('modules.button-0', ['text' => 'OK'])
		{{ Form::close() }}
	</div>
</div>
@stop
