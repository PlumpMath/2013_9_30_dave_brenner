@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Dashboard', 'icon' => 'dashboard', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Hello, '.$user_name])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Your Account'])
		<div class="box box-pad-0 border-bottom-0">
			<a href="{{ $your_info }}">Your info</a>
		</div>
		@include('modules.section_divide', ['name' => 'Your Children\'s Info'])
		@include('modules.section_divide', ['name' => 'This list allows you to edit your childrens\' info. If you are looking to register, choose a class before you choose which child will take it.'])
		<div class="box border-bottom-1">
			<ul>
				@foreach ($children as $child)
				<li class="box box-pad-1"><a href="{{ $child->link }}">{{{ $child->first_name.' '.$child->last_name }}}</a></li>
				@endforeach
				<li class="box box-pad-1"><a href="{{ $register_child }}">Register child</a></li>
			</ul>
		</div>
		<div class="box box-pad-0">
			<a href="{{ $enroll }}">Register for classes</a>
		</div>
		@include('modules.section_divide', ['name' => 'Account Settings'])
		<div class="box box-pad-0 border-bottom-1">
			<a href="{{ $signout }}">Sign out</a>
		</div>
		<div class="box box-pad-0 border-bottom-1">
			<p>You are currently @if (Auth::user()->subscribed) <span class="fg-5">receiving</span> @else <span class="fg-4">not receiving</span> @endif emails from us.</p>
			@if ( ! Auth::user()->subscribed)
			<br />
			<p class="warning">We only send emails with information vital to using this website. <span class="fg-4">Remaining unsubscribed may adversly affect your ability to register your child and/or stay informed on class cancellations and changes.</span></p>
			@endif
			<br />
			<p><a href="{{ $subscription_status }}">Change email subscription status</a></p>
		</div>
	</div>
	<div class="box-4 bg-0 border-left">
		@include('modules.section_divide', ['name' => 'Notifications'])
		@if ( ! empty($notifications))
		<div class="box box-pad-0 border-bottom-0 bg-1 center">
		No new messages
		</div>
		@else
		@foreach ($notifications as $notification)
		@include($notification->template, unserialize($notification->data))
		@endforeach
		@endif
		@include('modules.section_divide', ['name' => 'Current Classes'])
		@if (empty($classes))
		<div class="box box-pad-0 border-bottom-0 bg-1 center">
		<div class="measure center">You aren't currently signed up for any classes.<br/>Follow these steps to sign up:<br/><br/><span class="bold">Step one:</span> <a href="{{ $register_child }}">Register your kids</a> with our site.<br/><span class="bold">Step two:</span> <a href="{{ $enroll }}">Select a class</a> first, and then <a href="{{ URL::to('/select_child') }}">select a child</a> for that class.<br/><span class="bold">Step three:</span> If you have more than one child, select another class and then select your next child for this next class.<br/><span class="bold">Step four:</span> When done, <a href="{{ URL::to('/review') }}">review your order</a> and check out.</div>
		</div>
		@else
		@foreach ($classes as $class)
		@include('modules.lesson-2', $class)
		@endforeach
		@endif

		@if ( ! is_null($rsrcs))
		<div class="bg-1">
		@include('modules.section_divide', ['name' => 'Admin Functions'])
		@foreach ($rsrcs as $name => $quals)
			@if ($quals == 'break')
				<br/>
			@else
			<a href="{{ $quals['link'] }}" class="fg-2">
			<div class="box box-pad-0 border-bottom-0 type-1 bg-4">
				<span class="fg-0 type-3">View all</span> {{ ucfirst($name) }}
			</div>
			</a>
			@endif
		@endforeach
		</div>
		@endif
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop