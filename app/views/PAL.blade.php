@extends('layouts.master')

@section('content')
	<div class="PAL">
		<div class="PAL-PROGRAM">{{{ $PROGRAM }}}</div>
		<div class="PAL-YEAR">{{{ $YEAR }}}</div>
		<div class="PAL-NAME">{{{ $NAME }}}</div>
		<div class="PAL-ADDRESS">{{{ $ADDRESS }}}</div>
		<div class="PAL-TOWN">{{{ $TOWN }}}</div>
		<div class="PAL-ZIP">{{{ $ZIP }}}</div>
		<div class="PAL-PHONE">{{{ $PHONE }}}</div>
		<div class="PAL-DOB">{{{ $DOB }}}</div>
		<div class="PAL-AGE">{{{ $AGE }}}</div>
		@if ($MALE)
		<div class="PAL-MALE">X</div>
		@else
		<div class="PAL-FEMALE">X</div>
		@endif
		@if ($NEWPLAYER)
		<div class="PAL-NEWPLAYER">X</div>
		@else
		<div class="PAL-RETURNINGPLAYER">X</div>
		@endif
		<div class="PAL-GRADE">{{{ $GRADE }}}</div>
		<div class="PAL-SIGNATURE">{{{ $SIGNATURE }}}</div>
		<div class="PAL-DATE">{{{ $DATE }}}</div>
	</div>
@stop
