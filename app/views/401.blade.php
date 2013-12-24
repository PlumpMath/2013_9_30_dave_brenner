@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => '401 - Not Authorized', 'icon' => 'warning-sign', 'user_name' => $user_name])
@include('modules.banner', ['title' => '401 - Not Authorized'])
<div class="box bg-1">
	<div class="box measure bg-0 border-left border-bottom-0">
		@include('modules.section_divide', ['name' => 'What does this mean?'])
		<div class="box box-pad-0 bg-0 border-bottom-0">You aren't authorized to access this page. Perhaps you were logged out? Try <a href="{{ URL::to('/') }}">logging back in</a>.</div>
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop
