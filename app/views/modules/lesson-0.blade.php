<div class="box box-pad-0 bg-0 border-bottom-0">
	<div class="box">
		<div class="float-left bold">{{ $name }}</div>
		<div class="float-right fg-1 italic right">${{ $price }}/lesson</div>
	</div>
	<ul class="box fg-1 clear-over">
		@foreach ($details as $detail_name => $detail)
		<li class=""><span class="bold">{{ $detail_name }}:</span> {{ $detail }}</li>
		@endforeach
	</ul>
	<div class="box box-pad-2 center">
		<div class="btn-0 bg-4 fg-2">Add to Cart</div>
	</div>
</div>
