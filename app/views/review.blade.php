@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Review Your Order', 'icon' => 'eye-open', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Review Your Order'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Please select which child you are signing up for each lesson.'])
		<div class="box box-pad-0">Or, go back and choose different classes:</div>
		<a href="{{ $enroll }}">@include('modules.button-0', ['text' => 'Class Selection'])</a>
	</div>
	<div class="box-4 bg-0 border-left">
		@include('modules.section_divide', ['name' => 'Orders'])
		@foreach ($classes as $class)
		@include('modules.lesson-1', $class)
		@endforeach
		<div class="box box-pad-0 bg-1"><div class="float-left margin-0"><input class="input type-3" type="checkbox" name="terms_of_agreement"/></div><div class="float-left">I agree to the Terms of Service</div></div>
		<div class="box box-pad-0 bg-1"><div class="box-pad-5 float-left"><span class="bold">Total:</span> ${{ $total_price }}</div><div class="float-right"><a href="{{ $pay }}"><div class="btn-0 bg-4 fg-2">Finish &amp; Pay</div></a></div></div>
	</div>
	<div class="box box-pad-0 bg-0">{{ $links }}</div>
</div>
@stop