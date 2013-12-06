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
		<div class="box border-bottom-1">
			<ul>
				@if ( ! empty($children))
				<li class="box box-pad-1">Click on your child's name to edit their info</li>
				@endif
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
		<div class="box box-pad-0">
			<a href="{{ $site_preferences }}">Change site preferences</a>
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
		<div class="measure center">You haven't signed up for anything yet. To register a child, go <a href="{{ $enroll }}">here</a>, select the class/classes you'd like, and then click "Select Child For Class" to choose which children will take which class.</div>
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