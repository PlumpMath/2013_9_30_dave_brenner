<div class="box box-pad-0 border-bottom-1">
	<span class="bold">{{ $name }}</span>
	<ul class="box fg-1">
		@foreach ($details as $detail_name => $detail)
		<li><span class="bold">{{ $detail_name }}:</span> {{{ $detail }}}</li>
		@endforeach
	</ul>
	<br/>
	@include('modules.calendar', ['calendar' => $calendar])
</div>
