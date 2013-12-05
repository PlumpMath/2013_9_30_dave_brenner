@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Child Registered', 'icon' => 'user', 'user_name' => $user_name])
@include('modules.banner', ['title' => 'Great :)'])
<div class="box box-pad-0 measure center">{{ $child->first_name}}'s now a registered player!</div>
<div class="box box-pad-0 measure center">Shall we <a href="{{ $enroll }}">sign @if($child->gender === 'male'){{ 'him' }}@else{{ 'her' }}@endif up</a> for a class?</br>... or <a href="{{ $register_child }}">register</a> another child?</a></div>
@stop
