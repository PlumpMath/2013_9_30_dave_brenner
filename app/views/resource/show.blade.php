@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => $Resources, 'icon' => 'home', 'user_name' => $user_name])
@include('modules.banner', ['title' => $Resources])
<div class="index box bg-1">
    <div class="box-2">
        @include('modules.section_divide', ['name' => 'Tasks'])
        <div class="box box-pad-0">
            <ul>
                <li><a href="{{ $url['copy'] }}">Copy this {{ $Resource }}</a></li>
                {{ Form::open(['url' => $url['delete'], 'method' => 'DELETE']) }}
                <li><button class="button-3" type="submit">Delete this {{ $Resource }}</button></li>
                {{ Form::close() }}
                <li><a href="{{ $url['edit'] }}">Edit this {{ $Resource }}</a></li>
                {{ Form::open(['url' => $url['receipts'], 'method' => 'GET']) }}
                <input name="{{ $input_name }}" type="hidden" value="{{ $resource_id }}">
                <li><button class="button-3" type="submit">Retrieve attached Receipts</button></li>
                {{ Form::close() }}
                {{ Form::open(['url' => $url['lessons'], 'method' => 'GET']) }}
                <input name="{{ $input_name }}" type="hidden" value="{{ $resource_id }}">
                <li><button class="button-3" type="submit">Retrieve attached Lessons</button></li>
                {{ Form::close() }}
            </ul>
        </div>
    </div>
    <div class="box-4 bg-0 border-left">
        @include('modules.section_divide', ['name' => $Resources])
        <!-- resource block -->
        <ul class="rsrc">
            @foreach ($resource as $key => $value)
            <!-- resource elem -->
            <li class="rsrc-elem rsrc-inst">
                <div class="rsrc-inst-name">
                    <p class="rsrc-inst-name-text">{{ $key }}</p>
                </div>
                <div class="rsrc-inst-info">
                    <p class="rsrc-inst-info-text">{{ $value }}</p>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="box box-pad-0 bg-0"></div>
</div>
@stop
