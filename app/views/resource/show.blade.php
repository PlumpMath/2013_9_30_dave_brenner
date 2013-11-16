@extends('layouts.master')

@section('content')
    <div class="show wrap">
        <!-- header block -->
        <div class="header">
            <!-- header elem -->
            <div class="header-title">
                <p class="header-title-text">{{ $name }}</p>
            </div>
            <!-- header elem -->
            <div class="header-sub">
                <p class="header-sub-text">{{ $info }}</p>
            </div>
        </div>
        <!-- nav block -->
        <div class="nav">
        	<div class="nav-return">
        		<p class="nav-return-text">Return to <a href="{{ $url['index'] }}">{{ $Resources }}</a></p>
        	</div>
        </div>
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
@stop
