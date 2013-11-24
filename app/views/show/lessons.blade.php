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
                <li>Retrieve attached Receipts</li>
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
