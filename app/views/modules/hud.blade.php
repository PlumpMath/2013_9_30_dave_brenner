<div class="hud-2 box">
<p class="hud-3 fg-2">MENU</p>
<a href="{{ URL::to('/') }}"><div class="hud-1 hint--right hint--bounce" data-hint="Go to Home"><i class="hud-icon icon-home"></i></div></a>
<div class="hud-0"><i class="hud-animate hud-icon icon-{{ $icon }}"></i><span>Current Page: {{ $title }}</span></div>
@if ( ! is_null($user_name))
<a href="{{ URL::to('/dashboard') }}"><div class="hud-1"><i class="hud-icon icon-user"></i><span>{{{ $user_name }}}: Go to Dashboard</span></div></a>
<a href="{{ URL::to('/log/out') }}"><div class="hud-1"><i class="hud-icon icon-key"></i><span>Log Out</span></div></a>
@endif
</div>
