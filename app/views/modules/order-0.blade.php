<div class="box box-pad-0 border-bottom-1">
	<a href="{{ $remove_link }}"><i class="margin-0 icon-remove-sign fg-4"></i></a><span class="bold">{{ $name }}</span>
	<ul class="box fg-1">
		@foreach ($values as $key => $value)
		<li><span class="bold">{{ $key }}:</span> {{{ $value }}}</li>
		@endforeach
	</ul>
</div>
