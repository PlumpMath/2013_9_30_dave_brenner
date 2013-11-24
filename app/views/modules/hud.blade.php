<div class="hud-0 hint--right hint--bounce" data-hint="Current Page: {{ $title }}"><i class="hud-animate hud-icon icon-{{ $icon }}"></i></div>
@if ( ! is_null($user_name))
<a href="{{ URL::to('/dashboard') }}"><div class="hud-1 hint--right hint--bounce" data-hint="{{{ $user_name }}}: Go to Dashboard"><i class="hud-icon icon-user"></i></div></a>
@endif
