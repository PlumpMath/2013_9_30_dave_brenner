@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => $Resources, 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => $Resources])
<div class="index box bg-1">
    <div class="box measure bg-0 border-left border-bottom-0">
        @include('modules.section_divide', ['name' => $Resources])
        {{ Form::open(['url' => $url['create'], 'method' => 'POST']) }}
        <ul class="box pl box-pad-0 rsrc">
            <li class="box-pad-0">
                How many dates will this lesson have? Add together the number of black out dates, make-ups, lessons, etc.
            </li>
            @foreach ($fields as $field)
            <li>
            @include('modules.input-0', $field)
            </li>
            @endforeach         
        </ul>
        @include('modules.button-0', ['text' => 'Make'])
        {{ Form::close() }}
    </div>
    <div class="box box-pad-0 bg-0"></div>
</div>
@stop
