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
		@if (empty($classes))
		<div class="box box-pad-0 border-bottom-0 bg-1 center">
		<span class="type-1">Sorry! :(</span><br/>You either haven't chosen any classes, or you have, but they've expired.
		</div>
		@else
		{{ Form::open(['url' => $pay]) }}
		@foreach ($classes as $class)
		@include('modules.lesson-3', $class)
		@endforeach
		@include('modules.calendar-key')
		<div class="box box-pad-1 bg-1"><div class="float-left margin-0"><input class="input type-3" type="checkbox" name="reviewed" @if (Session::has('_old_input') && isset(Session::get('_old_input')['reviewed'])) checked@endif/></div><div class="float-left measure">I have reviewed these dates carefully and I agree to the class schedule. Also, I understand there are no refunds/credits/make-ups for missed classes.</div></div>
		@if ($errors->first('reviewed'))
		<div class="box box-pad-3 fg-4 bg-1 reviewed-errors visible-toggle visible">
		@else
		<div class="box box-pad-3 fg-4 bg-1 reviewed-errors visible-toggle invisible">
		@endif
			<p>{{ $errors->first('reviewed') }}</p>
		</div>
		@if ($pal)
		<div class="box box-pad-1 bg-1">
		<input type="hidden" name="is_pal" value="1">
		@include('modules.input-1',['name' => 'pal', 'label' => 'I agree to the PAL Terms and Conditions'])
		I/We, the parent/guardian of the registered child(ren), hereby give my consent for participation in the selected activity and do claim that he/she is in perfect physical condition to participate in said activity.<br/><br/>Furthermore, I/we, the parent/guardian of the above named candidate for a position on a league team hereby give my/our approval to his/her participation in all league activities during the current season. I/we assume all risks and hazards incidental to such participation including transportation to and from the activies; and I/we do herby waive, release, absolve, indemify and agree to hold harmless the Police Athletic League, Inc., associated organizations, the organizers, sponsors, supervisors, participants and persons transporting my/our child to or from activites, for any claim arising out of an injury to my/our child, except to the extent and in the amount covered by accident or liability insure.<br/><br/>I/We, agree to return within 7 days or sooner, after notification, the uniform and other equipment issued to my/our child in as good condition as when received except normal wear and tear or pay equivalent cost.<br/><br/>The Suffolk County Police Athletic League has adopted a zero tolerance policy for violence. This includes physical acts of violence, threats of violence or threatening behavior. A violation committed by any participant (player, coach, referee), parent, or fan, will result in immediate expulsion from the league and a fine to the organization from which he or she belongs.
		</div>
		@endif
		@if ($neysa)
		<input type="hidden" name="is_neysa" value="1">
		<div class="box box-pad-1 bg-1">
		@include('modules.input-1',['name' => 'neysa', 'label' => 'I agree to the NEYSA Terms and Conditions'])
		I, the parent/guardian of the registered child(ren), give consent for participation in the selected activity. I assume all risks/hazards incidental to such participatioin, and waive, release, absolve, indemnify, and agree to hold harmless Northeast Youth Sports Association, as well as associated organizations, sponsors, supervisors, and participants for any claim arising out of an injury, except to the extent and in the amount covered by accident or liability insurance. I submit that my child is in perfect physical condition to participate in this program. Any and all digital images recorded are property of NEYSA and may be used for promotional purposes.
		</div>
		@endif
		<div class="box box-pad-0 bg-1"><div class="box-pad-5 float-left"><span class="bold">Total:</span> ${{ $total_price }}</div><div class="float-right"><button type="submit" class="btn-0 bg-4 fg-2">Finish &amp; Pay</button></div></div>
		{{ Form::close() }}
		@endif
	</div>
	<div class="box box-pad-0 bg-0">{{ $links }}</div>
</div>
@stop