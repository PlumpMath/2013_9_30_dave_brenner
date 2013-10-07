<div class="box box-pad-0 border-bottom-1">
	<span class="bold">{{ $name }}</span>
	<ul class="box fg-1">
		@foreach ($values as $key => $value)
		<li><span class="bold">{{ $key }}:</span> {{{ $value }}}</li>
		@endforeach
	</ul>
</div>
