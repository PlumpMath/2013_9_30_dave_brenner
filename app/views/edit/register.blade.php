@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Edit Your Information', 'icon' => 'edit', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Edit Your Information'])
<div class="box bg-1">
	<div class="box measure bg-0 border-left border-bottom-0">
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
		</div>
		@include('modules.button-0', ['text' => 'OK'])
		{{ Form::close() }}
	</div>
</div>
@stop
