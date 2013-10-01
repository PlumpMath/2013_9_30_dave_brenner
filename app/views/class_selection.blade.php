@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Class Selection', 'icon' => 'search', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Class Selection'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Filters'])
		<div class="box box-pad-0">
			@foreach ($filters as $filter)
			@include('modules.menu-2', $filter)
			@endforeach
		</div>
		@include('modules.section_divide', ['name' => 'Your Order'])
		@foreach ($orders as $order)
		@include('modules.order-0', $order)
		@endforeach
		<div class="box box-pad-0"><div class="box-pad-5 float-left"><span class="bold">Total:</span> ${{ $total_price }}</div><div class="float-right"><div class="btn-0 bg-4 fg-2">Finish &amp; Pay</div></div></div>
	</div>
	<div class="box-4 bg-0">
		@include('modules.section_divide', ['name' => 'Classes'])
		@foreach ($classes as $class)
		@include('modules.lesson-0', $class)
		@endforeach
	</div>
</div>
@stop
