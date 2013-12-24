@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => '500 - Server Error', 'icon' => 'warning-sign', 'user_name' => $user_name])
@include('modules.banner', ['title' => '500 - Server Error'])
<div class="box bg-1">
	<div class="box measure bg-0 border-left border-bottom-0">
		@include('modules.section_divide', ['name' => 'What does this mean?'])
		<div class="box box-pad-0 bg-0 border-bottom-0">Something went wrong! We apologize if this has caused any inconvenience. Feel free to contact us at <span class="bold">631-776-8242</span> or <span class="bold"><a href="mailto:help@myafterschoolprograms.com">help@myafterschoolprograms.com</a></span> if the error is recurring.</div>
	</div>
	<div class="box box-pad-0 bg-0"></div>
</div>
@stop
