<div class="box box-pad-3">
	<label class="label" for="{{ $name }}">{{ $label }}</label>
	<select class="input smaller-measure type-3" name="{{ $name }}">
		@foreach ($options as $option)
		<option>{{{ $option }}}</option>
		@endforeach
	</select>
</div>
