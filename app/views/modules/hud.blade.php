<div class="hud-0 hint--left hint--bounce" data-hint="Current Page: {{ $title }}"><i class="hud-animate hud-icon icon-{{ $icon }}"></i></div>
@if ( ! is_null($user_name))
<div class="hud-1 hint--left hint--bounce" data-hint="{{{ $user_name }}}"><i class="hud-icon icon-user"></i></div>
@endif
