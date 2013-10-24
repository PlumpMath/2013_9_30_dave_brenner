<div class="box box-pad-0 bg-0 border-bottom-0">
	<div class="box">
		<div class="bold">{{ $name }}</div>
	</div>
	<ul class="box fg-1 clear-over">
		@foreach ($details as $detail_name => $detail)
		<li class=""><span class="bold">{{ $detail_name }}:</span> {{ $detail }}</li>
		@endforeach
	</ul>
</div>
