@extends('layouts.master')

@section('content')
    <div class="index wrap">
        <!-- header block -->
        <div class="header">
            <!-- header elem -->
            <div class="header-title">
                <p class="header-title-text">{{ $Resources }}</p>
            </div>
            <!-- header elem -->
            <div class="header-sub">
                <p class="header-sub-text"></p>
            </div>
        </div>
        <!-- nav block -->
        <div class="nav">
            <div class="nav-return">
                <p class="nav-return-text">Return to <a href="{{ $url['home'] }}">Home</a></p>
            </div>
        </div>
        <!-- resource block -->
        <ul class="rsrc">
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
@stop
