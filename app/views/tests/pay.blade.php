@include('modules.header')
@include('modules.hud')
@include('modules.banner', ['title' => 'Payment'])
<div class="box bg-1">
	<div class="box-2">
		<div class="box box-pad-0 bg-0 fg-1 border-0">Your Order</div>
		<div class="box box-pad-0 border-bottom-1">
			<div class="box">
				<span class="bold">4:30pm-5:30pm, 8/30-10/5</span>
			</div>
			<ul class="box fg-1">
				<li><span class="bold">For:</span> John</li>
				<li><span class="bold">Price:</span> $139</li>
			</ul>
		</div>
		<div class="box box-pad-0 border-bottom-1">
			<span class="bold">4:30pm-5:30pm, 12/30-12/35</span>
			<ul class="box fg-1">
				<li><span class="bold">For:</span> John</li>
				<li><span class="bold">Price:</span> $139</li>
			</ul>
		</div>
		<div class="box box-pad-0"><span class="bold">Total:</span> $278</div>
	</div>
	<div class="box-4 bg-0">
		<div class="box box-pad-0 fg-1 border-0">Payment Info</div>
		<div class="box box-pad-0">
			<div class="box box-pad-3">
				<label class="label fg-1" for="email">First Name</label>
				<input class="input measure type-3" type="text" name="email"/>
			</div>
			<div class="box box-pad-3">
				<label class="label fg-1" for="password">Last Name</label>
				<input class="input measure type-3" type="text" name="password"/>
			</div>
			<div class="box box-pad-3">
				<label class="label fg-1" for="email">E-mail</label>
				<input class="input measure type-3" type="text" name="email"/>
			</div>
			<div class="box box-pad-3">
				<label class="label fg-1" for="password">Address</label>
				<input class="input measure type-3" type="text" name="password"/>
			</div>
			<div class="box box-pad-3">
				<label class="label fg-1" for="email">City</label>
				<input class="input measure type-3" type="text" name="email"/>
			</div>
			<div class="box box-pad-3">
				<label class="label fg-1" for="password">State</label>
				<input class="input measure type-3" type="text" name="password"/>
			</div>
			<div class="box box-pad-3">
				<label class="label fg-1" for="password">Zip</label>
				<input class="input measure type-3" type="text" name="password"/>
			</div>
		</div>
		<div class="box box-pad-2 center">
			<div class="btn-0 bg-4 fg-2">OK</div>
		</div>
	</div>
</div>
