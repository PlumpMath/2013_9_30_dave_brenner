@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => $Resources, 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => $Resources])
<div class="index box bg-1">
    <div class="box-2">
        @include('modules.section_divide', ['name' => 'Tasks'])
        <div class="box box-pad-0">
        </div>
    </div>
    <div class="box-4 bg-0 border-left">
        @include('modules.section_divide', ['name' => $Resources])
        {{ Form::open(['url' => $url['store'], 'method' => 'POST']) }}
        <ul class="box pl box-pad-0 rsrc">
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