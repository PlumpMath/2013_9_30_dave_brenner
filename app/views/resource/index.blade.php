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
                <li><a href="{{ $url['create'] }}">Create a {{ $Resource }}</a></li>
            </ul>
        </div>
    </div>
    <div class="box-4 bg-0 border-left">
        @include('modules.section_divide', ['name' => $Resources])
        <ul class="box rsrc">
            @if (empty($resources))
            <!-- resource elem -->
            <li class="rsrc-elem rsrc-inst">
                <div class="rsrc-inst-empty">
                    <p class="rsrc-inst-empty-text">There are no {{ $Resources }}! <a href="{{ $url['create'] }}">Create one?</a></p>
                </div>
            </li>            
            @else
            @foreach ($resources as $resource)
            <!-- resource elem -->
            <li class="rsrc-elem rsrc-inst">
                <div class="rsrc-elem-checkbox">
                    <i class="icon icon-circle-blank"></i>
                </div>
                <a href="{{ $url['index'].'/'.$resource['id'] }}">
                    <div class="rsrc-inst-name">
                        <p class="rsrc-inst-name-text">{{ $resource['name'] }}</p>
                    </div>
                    <div class="rsrc-inst-info">
                        <p class="rsrc-inst-info-text">{{ $resource['info']}}</p>
                    </div>
                </a>
            </li>
            @endforeach
            @endif
        </ul>
    </div>
    <div class="box box-pad-0 bg-0"></div>
</div>
@stop
