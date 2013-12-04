@extends('layouts.master')

@section('content')
@include('modules.header')
@include('modules.hud', ['title' => 'Unsubscribe', 'icon' => 'home', 'user_name' => null])
@include('modules.banner', ['title' => 'You\'re unsubscribed'])
<div class="box box-pad-0 measure center">Sorry for the confusion, your email has been added to a list and will not be emailed again.</div>
@stop
