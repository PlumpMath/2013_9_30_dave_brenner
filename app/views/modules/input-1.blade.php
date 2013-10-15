@if ($errors->first($name))
<div class="box box-pad-3 with-errors">
@else
<div class="box box-pad-3">
@endif
	<div class="float-left margin-0">
	@if (isset($old[$name]))
		<input class="input type-3" type="checkbox" name="{{ $name }}" checked="true"/>
	@else
		<input class="input type-3" type="checkbox" name="{{ $name }}"/>
	@endif
	</div>
	<div class="float-left">
		{{ $label }}
	</div>
</div>
@if ($errors->first($name))
<div class="box box-pad-3 fg-4 {{ $name }}-errors visible-toggle visible">
@else
<div class="box box-pad-3 fg-4 {{ $name }}-errors visible-toggle invisible">
@endif
	<p>{{ $errors->first($name) }}</p>
</div>
