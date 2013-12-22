@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Register', 'icon' => 'edit', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Register'])
<div class="box bg-1">
	<div class="box-2">
		@include('modules.section_divide', ['name' => 'Progress'])
		<div class="fg-4">
		@include('modules.menu-0', ['item' => 'Your Info'])
		</div>
	</div>
	<div class="box-4 bg-0">
		<div class="box box-pad-0 fg-1 border-0">Current</div>
		{{ Form::open(['url' => $verify]) }}
		<div class="box box-pad-0">
			@foreach($fields as $field)
				@if ($field['type'] === 'form-hint')
				<div class="box box-pad-6">{{ $field['label'] }}</div>
				@else
				@include('modules.input-0', $field)
				@endif
			@endforeach
		@include('modules.input-1', ['name' => 'terms_of_agreement','label' => 'I have read and agree to the <a href="'.$toa.'">Terms and Conditions</a>'])
		@include('modules.input-1', ['name' => 'privacy_policy','label' => 'I have read and agree to the <a href="'.$pp.'">Privacy Policy</a>'])
		</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">@include('modules.input-1', ['name' => 'no_refunds', 'label' => 'No Refunds'])<br/>By signing up into this program, you are actively reserving a space for your child to participate. Personal scheduling conflicts that may prevent you from attending lass are not the responsibility of the program. Be sure to know your schedule before you sign up. There are no refunds/credits/make-ups for missed classes.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">@include('modules.input-1', ['name' => 'make_up_date', 'label' => 'Make Up Date on Schedule'])<br/>Most class schedules include a make up date. This extra date would be used only in the event of a cancelled class and is not intended for personal make ups for missed classes. This date should be considered as a part of the session schedule. No refunds/credits can be given for a missed make up class.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">@include('modules.input-1', ['name' => 'class_level', 'label' => 'Class Level']) <br/>A beginner is someone who has never played tennis. An advanced beginner has played before, or has taken some lessons, but still needs significant guidance on basic stroke production, and has substantially limited ability to keep the ball in play. In this program, both beginner and advanced beginners may share the same class. By signing up, you agree that your child's playing level is appropriate for this program and class structure. Contact us if you are not sure. There can be no refunds/credits for inappropriate class placements.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">
		@include('modules.input-1', ['name' => 'courtesy_sign_up', 'label' => 'Courtesy Sign Up'])<br/>The courtesy sign-up allows you to re-enroll your children into the same class for the next session without concern of losing their spots. It takes place shortly before the open sign-up where anyone can join. The only notification for the courtesy sign-up is done through email. Please make sure you are receiving our emails in your inbox.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">@include('modules.input-1', ['name' => 'viewing_classes', 'label' => 'Viewing Classes'])<br/>Due to the potentially large groups of parents that can form on the sidelines of lessons causing hazardous viewing and playing conditions, parents and siblings may not be on court while lesson is in progress. Please stay in lobby/viewing area or behind tennis court curtain where permissible.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">@include('modules.input-1', ['name' => 'program_facility', 'label' => 'Program Facility'])<br/>The indoor facility housing your program may be a private club containing other recreational areas and equipment. To take advantage of this equipment whil your children play, you can speak to club personnel regarding any fees needed to allow you access to this equipment. Otherwise, these facilities gladly extend the courtesy for you to enjoy the lobby and/or viewing area during lesson hours. In consideration of club and its members, please encourage good behavior on the part of any siblings who remain with you during classes.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">@include('modules.input-1', ['name' => 'equipment', 'label' => 'Equipment'])<br/>Tennis players need to supply their own racquets. If you need to buy one, use the table below as a general guide. A beginner racquet can run between $15-25 in any sporting good store:<br/>1st-2nd graders: 23" Racquet<br/>2nd-5th graders: 25" Racquet<br/>5th-Adult: 27" Racquet</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">@include('modules.input-1', ['name' => 'class_changes', 'label' => 'Class Changes'])<br/>Classes are subject to change based on sign-up. In the event that a class you  have signed up for has been changed to a different time or day, we will contact you. At that time, you can let us know if you are able to attend the newly scheduled class. If you cannot, you will be refunded your tuition in full.</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">@include('modules.input-1', ['name' => 'substitute_pros', 'label' => 'Substitute Pros'])<br/>It is not uncommon for substitute pros to teach during the course of a lesson series. This will not interefere with the student's improvement since basic universal skills are taught and reinforced at this level of play.</div>
		@include('modules.button-0', ['text' => 'I have read and agree to the above conditions. Proceed to next step'])
		{{ Form::close() }}
	</div>
</div>
@stop
