<div class="box box-pad-3">
	<label class="label" for="{{ $name }}">{{ $label }}</label>
	<select class="input input-full smaller-measure type-3" name="{{ $name }}">
		@foreach ($options as $id => $option)
		<option value="{{ $id }}" @if($id == $selected)selected@endif>{{{ $option }}}</option>
		@endforeach
	</select>
</div>
