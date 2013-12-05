<div class="box box-pad-0 border-bottom-0 @if ($incart) bg-5 @else bg-0 @endif">
	<div class="box">
		<div class="float-left bold">{{ $name }}</div>
		<div class="float-right fg-1 italic right">${{ $price }} &mdash; <a href="{{ $link }}">{{ $actionable }}</a></div>
	</div>
	<ul class="box fg-1 clear-over">
		{{ ''; $i = 0 }}
		@foreach ($details as $detail_name => $detail)
		@if ($detail_name === 'break')
		<br/>
		@elseif ($detail_name === 'start_box')
		<ul class="warning">
		@elseif ($detail_name === 'end_box')
		</ul>
		@else
		<li class="detail_name_{{ ++$i }}"><span class="bold">{{ $detail_name }}:</span> {{ $detail }}</li>
		@endif
		@endforeach
	</ul>
</div>
