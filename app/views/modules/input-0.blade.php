@if ($errors->first($name))
<div class="box box-pad-3 with-errors">
@else
<div class="box box-pad-3">
@endif
	<label class="label fg-1" for="{{ $name }}">{{ $label }}@if (isset($required) && $required == true) <span class="fg-4">*</span>@endif</label>
	@if (isset($old[$name]))
	<input class="input input-full smaller-measure type-3" type="{{ $type }}" name="{{ $name }}" value="{{{ $old[$name] }}}"/>
	@else
	<input class="input input-full smaller-measure type-3" type="{{ $type }}" name="{{ $name }}"/>
	@endif
</div>
@if ($errors->first($name))
<div class="box box-pad-3 fg-4 {{ $name }}-errors visible-toggle visible">
@else
<div class="box box-pad-3 fg-4 {{ $name }}-errors visible-toggle invisible">
@endif
	<p>{{ $errors->first($name) }}</p>
</div>
