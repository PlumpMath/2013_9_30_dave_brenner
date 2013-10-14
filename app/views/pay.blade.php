@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Checkout', 'icon' => 'shopping-cart', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Checkout'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Your Order'])
		@foreach ($orders as $order)
		@include('modules.order-1', $order)
		@endforeach
		<div class="box box-pad-0"><span class="bold">Total:</span> ${{ $total_price }}</div>
	</div>
	<div class="box-4 bg-0 border-left border-bottom-0">
		@include('modules.section_divide', ['name' => 'Billing Info'])
		<div class="box box-pad-0 bg-1"><div class="float-left margin-0"><input class="input type-3" type="checkbox" name="terms_of_agreement"/></div><div class="float-left">My billing information is the same as from my account</div></div>
		{{ Form::open(['url' => $verify]) }}
		<div class="box box-pad-0">
			@foreach($billing_fields as $field)
				@include('modules.input-0', $field)
			@endforeach
		</div>
		@include('modules.section_divide', ['name' => 'Payment Info'])
		<div class="box box-pad-0">
			@foreach($payment_fields as $field)
				@include('modules.input-0', $field)
			@endforeach
		</div>
		@include('modules.button-0', ['text' => 'OK'])
		{{ Form::hidden('amount', $total_price) }}
		{{ Form::hidden('description', "Order for ".$user_name) }}

		{{ Form::close() }}
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop
