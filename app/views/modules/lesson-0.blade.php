<div class="box box-pad-0 bg-0 border-bottom-0">
	<div class="box">
		<div class="float-left bold">{{ $name }}</div>
		<div class="float-right fg-1 italic right">${{ $price }}/lesson &mdash; <a href="{{ $link }}">{{ $actionable }}</a></div>
	</div>
	<ul class="box fg-1 clear-over">
		{{ ''; $i = 0 }}
		@foreach ($details as $detail_name => $detail)
		<li class="detail_name_{{ ++$i }}"><span class="bold">{{ $detail_name }}:</span> {{ $detail }}</li>
		@endforeach
	</ul>
</div>
