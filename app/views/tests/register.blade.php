@include('modules.header')
@include('modules.hud')
@include('modules.banner', ['title' => 'Register'])
<div class="box bg-1">
	<div class="box-2">
		<div class="box box-pad-0 bg-0 fg-1 border-0">Completed</div>
		<div class="box box-pad-0 border-bottom-1">
			<i class="margin-0 icon-remove-sign fg-4"></i><span>User Information</span>
		</div>
		<div class="box box-pad-0 border-bottom-1">
			<i class="margin-0 icon-remove-sign fg-4"></i><span>Child Information</span>
		</div>
		<div class="box box-pad-0 border-bottom-1">
			<i class="margin-0 icon-remove-sign fg-4"></i><span>Child Information</span>
		</div>
		<div class="box box-pad-0 border-bottom-1">
			<i class="margin-0 icon-plus-sign fg-5"></i><span>Add a Child</span>
		</div>
		<div class="box box-pad-2 center">
			<div class="btn-0 bg-4 fg-2">Finish</div>
		</div>
	</div>
	<div class="box-4 bg-0">
		<div class="box box-pad-0 fg-1 border-0">Current</div>
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
			<div class="btn-0 bg-4 fg-2">OK!</div>
		</div>
	</div>
</div>
