@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => '404 - Page Not Found', 'icon' => 'warning-sign', 'user_name' => $user_name])
@include('modules.banner', ['title' => '404 - Page Not Found'])
<div class="box bg-1">
	<div class="box measure bg-0 border-left border-bottom-0">
		@include('modules.section_divide', ['name' => 'What does this mean?'])
		<div class="box box-pad-0 bg-0 border-bottom-0">The page you're looking for doesn't exist. It may have been deleted, or you may have mistyped your URL.</div>
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop
