@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Select Child For Class', 'icon' => 'eye-open', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Select Child For Class'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Please select which child you are signing up for each lesson.'])
		<div class="box box-pad-0">Or, go back and choose different classes:</div>
		<a href="{{ $enroll }}">@include('modules.button-0', ['text' => 'Class Selection'])</a>
	</div>
	<div class="box-4 bg-0 border-left">
		@include('modules.section_divide', ['name' => 'Orders'])
		@if (empty($classes))
		<div class="box box-pad-0 border-bottom-0 bg-1 center">
		<span class="type-1">Sorry! :(</span><br/>You either haven't chosen any classes, or you have, but they've expired.
		</div>
		@else
		{{ Form::open(['url' => $pay]) }}
		@foreach ($classes as $class)
		@include('modules.lesson-1', $class)
		@endforeach
		<div class="box box-pad-0 bg-1"><div class="box-pad-5 float-left"><span class="bold">Total:</span> ${{ $total_price }}</div><div class="float-right"><button type="submit" class="btn-0 bg-4 fg-2">Review Your Order</button></div></div>
		{{ Form::close() }}
		@endif
	</div>
	<div class="box box-pad-0 bg-0">{{ $links }}</div>
</div>
@stop