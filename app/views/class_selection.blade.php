@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Class Selection', 'icon' => 'search', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Class Selection'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Filters'])
			{{ Form::open(['url' => $enroll, 'method' => 'GET']) }}
		<div class="box box-pad-0">
			@foreach ($filters as $filter)
			@include('modules.menu-2', $filter)
			@endforeach
		</div>
		@include('modules.button-0', ['text' => 'Apply'])
			{{ Form::close() }}
		@include('modules.section_divide', ['name' => 'Your Order'])
		@foreach ($orders as $order)
		@include('modules.order-0', $order)
		@endforeach
		<div class="box box-pad-0"><div class="box-pad-5 float-left"><span class="bold">Total:</span> ${{ $total_price }}</div><div class="float-right"><a href="{{ $review }}"><div class="btn-0 bg-4 fg-2">Review Order</div></a></div></div>
	</div>
	<div class="box-4 bg-0 border-left">
		@include('modules.section_divide', ['name' => 'Classes'])
		@if ($classes === [])
		<div class="box box-pad-0 border-bottom-0 bg-1 center">
		<span class="type-1">Sorry! :(</span><br/>There aren't any classes with the filters you selected. Try something else?
		</div>
		@else
		@foreach ($classes as $class)
		@include('modules.lesson-0', $class)
		@endforeach
		@endif
	</div>
	<div class="box box-pad-0 bg-0">{{ $links }}</div>
</div>
@stop
