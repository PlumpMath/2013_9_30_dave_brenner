@if ($errors->first($name))
<div class="box box-pad-3 with-errors">
@else
<div class="box box-pad-3">
@endif
	<label class="label" for="{{ $name }}">{{ $label }}</label>
	<select class="input input-full smaller-measure type-3" name="{{ $name }}">
		@foreach ($options as $id => $option)
		<option value="{{ $id }}"
		@if($id == $selected)
		selected
		@endif>{{{ $option }}}</option>
		@endforeach
	</select>
</div>
@if ($errors->first($name))
<div class="box box-pad-3 fg-4 {{ $name }}-errors visible-toggle visible">
@else
<div class="box box-pad-3 fg-4 {{ $name }}-errors visible-toggle invisible">
@endif
	<p>{{ $errors->first($name) }}</p>
</div>
