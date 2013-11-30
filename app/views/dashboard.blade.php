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
		<div class="box box-pad-0">
			<a href="{{ $signout }}">Sign out</a>
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
		You haven't signed up for anything yet.
		</div>
		@else
		@foreach ($classes as $class)
		@include('modules.lesson-2', $class)
		@endforeach
		@endif

		@if ( ! is_null($rsrcs))
		@foreach ($rsrcs as $name => $quals)
			<div class="box box-pad-0 border-bottom-0 center">
				<a href="{{ $quals['link'] }}">{{ $name }}</a>
			</div>
		@endforeach
		@endif
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop