@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => $Resources, 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => $Resources])
<div class="index box bg-1">
    <div class="box measure bg-0 border-left border-bottom-0">
        @include('modules.section_divide', ['name' => $Resources])
        {{ Form::open(['url' => $url['store'], 'method' => 'POST']) }}
        <ul class="box pl box-pad-0 rsrc">
            @foreach ($fields as $field)
            <li>
            @include('modules.input-0', $field)
            </li>
            @endforeach
            <li class="box-pad-0">
                Or, does the user already have an account? If so, enter a User ID rather than an email:
            </li>
            <li>
            @include('modules.input-0', ['name' => 'user_id', 'type' => 'text', 'label' => 'User ID'])
            </li>
            <li class="box-pad-0">
                Or, does the child already exist? If so, enter a Child ID rather than a name:
            </li>
            <li>
            @include('modules.input-0', ['name' => 'child_id', 'type' => 'text', 'label' => 'Child ID'])
            </li>            
        </ul>
        @include('modules.button-0', ['text' => 'Make'])
        {{ Form::close() }}
    </div>
    <div class="box box-pad-0 bg-0"></div>
</div>
@stop
