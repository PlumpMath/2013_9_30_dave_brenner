@include('modules.header')
@include('modules.hud')
@include('modules.banner', ['title' => 'Class Selection'])
<div class="box bg-1">
	<div class="box-2">
		<div class="box box-pad-0 bg-0 fg-1 border-0">Filters</div>
		<div class="box box-pad-0">
			<div class="box box-pad-3">
				<label class="label" for="locations">Location</label>
				<select class="input smaller-measure type-3" name="locations">
					<option>Melville</option>
					<option>Bayside</option>
					<option>Ronkonkama</option>
				</select>
			</div>
			<div class="box box-pad-3">
				<label class="label" for="activities">Activity</label>
				<select class="input smaller-measure type-3" name="activities">
					<option>Tennis</option>
					<option>Art</option>
				</select>
			</div>
			<div class="box">
				<label class="label" for="child">Child</label>
				<select class="input smaller-measure type-3" name="child">
					<option>John Jr.</option>
					<option>Jane</option>
				</select>
			</div>
		</div>
		<div class="box box-pad-0 bg-0 fg-1 border-0">Your Order</div>
		<div class="box box-pad-0 border-bottom-1">
			<div class="box">
				<i class="margin-0 icon-remove-sign fg-4"></i><span class="bold">4:30pm-5:30pm, 8/30-10/5</span>
			</div>
			<ul class="box fg-1">
				<li><span class="bold">For:</span> John</li>
				<li><span class="bold">Price:</span> $139</li>
			</ul>
		</div>
		<div class="box box-pad-0 border-bottom-1">
			<i class="margin-0 icon-remove-sign fg-4"></i><span class="bold">4:30pm-5:30pm, 12/30-12/35</span>
			<ul class="box fg-1">
				<li><span class="bold">For:</span> John</li>
				<li><span class="bold">Price:</span> $139</li>
			</ul>
		</div>
		<div class="box box-pad-0"><div class="box-pad-5 float-left"><span class="bold">Total:</span> $278</div><div class="float-right"><div class="btn-0 bg-4 fg-2">Finish &amp; Pay</div></div></div>
	</div>
	<div class="box-4 bg-0">
		<div class="box box-pad-0 fg-1 border-0">Classes</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">
			<div class="box">
				<div class="float-left bold">Sundays at 4pm</div>
				<div class="float-right fg-1 italic right">$17/lesson</div>
			</div>
			<ul class="box fg-1 clear-over">
				<li class=""><span class="bold">Number of Lessons:</span> 8</li>
				<li class=""><span class="bold">Eligible Grades:</span> 3<sup>rd</sup>, 4<sup>th</sup> &amp; 5<sup>th</sup></li>
				<li class=""><span class="bold">Starts:</span> Aug 5<sup>th</sup></li>
				<li class=""><span class="bold">Ends:</span> Oct 12<sup>th</sup></li>
			</ul>
			<div class="box box-pad-2 center">
				<div class="btn-0 bg-4 fg-2">Add to Cart</div>
			</div>
		</div>
		<div class="box box-pad-0 bg-0 border-bottom-0">
			<div class="box-3 bold">Sundays at 4pm</div>
			<div class="box-3 fg-1 italic right">$17/lesson</div>
			<ul class="box fg-1 clear-over">
				<li class="">8 lessons</li>
				<li class="">3<sup>rd</sup>, 4<sup>th</sup> &amp; 5<sup>th</sup> grades</li>
				<li class="">Starts Aug 5<sup>th</sup></li>
				<li class="">Ends Oct 12<sup>th</sup></li>
			</ul>
			<div class="box box-pad-2 center">
				<div class="btn-0 bg-4 fg-2">Add to Cart</div>
			</div>
		</div>
		<div class="box box-pad-0 bg-0">
			<div class="box-3 bold">Sundays at 4pm</div>
			<div class="box-3 fg-1 italic right">$17/lesson</div>
			<ul class="box fg-1 clear-over">
				<li class="">8 lessons</li>
				<li class="">3<sup>rd</sup>, 4<sup>th</sup> &amp; 5<sup>th</sup> grades</li>
				<li class="">Starts Aug 5<sup>th</sup></li>
				<li class="">Ends Oct 12<sup>th</sup></li>
			</ul>
			<div class="box box-pad-2 center">
				<div class="btn-0 bg-4 fg-2">Add to Cart</div>
			</div>
		</div>
	</div>
</div>
