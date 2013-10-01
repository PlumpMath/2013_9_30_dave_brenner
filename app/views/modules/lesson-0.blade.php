<div class="box box-pad-0 bg-0 border-bottom-0">
	<div class="box">
		<div class="float-left bold">{{ $name }}</div>
		<div class="float-right fg-1 italic right">${{ $price }}/lesson</div>
	</div>
	<ul class="box fg-1 clear-over">
		<li class=""><span class="bold">Number of Lessons:</span> {{ $lesson_number }}</li>
		<li class=""><span class="bold">Eligible Grades:</span> @foreach($grades as $grade) @include('modules.suffixer', ['value' => $grade]) @endforeach</li>
		<li class=""><span class="bold">Starts:</span> {{ $start_month }} @include('modules.suffixer', ['value' => $start_day])</li>
		<li class=""><span class="bold">Ends:</span> {{ $start_month }} @include('modules.suffixer', ['value' => $start_day])</li>
	</ul>
	<div class="box box-pad-2 center">
		<div class="btn-0 bg-4 fg-2">Add to Cart</div>
	</div>
</div>
