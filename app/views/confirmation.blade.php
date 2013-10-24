@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Order Confirmation', 'icon' => 'eye-open', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Order Confirmation'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Thank you!'])
		<div class="box box-pad-0">You can always navigate back to this page to view your receipt.</div>
		<div class="box box-pad-0">Would you like to <a href="#" onclick="javascript:window.print()">print your confirmation</a>?</div>
	</div>
	<div class="box-4 bg-0 border-left">
		@include('modules.section_divide', ['name' => 'Order #'.$confirmation_id])
		@if (empty($receipts))
		<div class="box box-pad-0 border-bottom-0 bg-1 center">
		Nothing attached to this receipt? How'd you get here, anyways?
		</div>
		@else
		@foreach ($receipts as $receipt)
		@include('modules.lesson-0', $receipt)
		@endforeach
		@endif
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop