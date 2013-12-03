<div class="hud-2 box">
<a href="{{ URL::to('/') }}"><div class="hud-1 hint--right hint--bounce" data-hint="Go to Home"><i class="hud-icon icon-home"></i></div></a>
<div class="hud-0 hint--right hint--bounce" data-hint="Current Page: {{ $title }}"><i class="hud-animate hud-icon icon-{{ $icon }}"></i></div>
@if ( ! is_null($user_name))
<a href="{{ URL::to('/dashboard') }}"><div class="hud-1 hint--right hint--bounce" data-hint="{{{ $user_name }}}: Go to Dashboard"><i class="hud-icon icon-user"></i></div></a>
<a href="{{ URL::to('/log/out') }}"><div class="hud-1 hint--right hint--bounce" data-hint="Log Out"><i class="hud-icon icon-key"></i></div></a>
@endif
</div>
