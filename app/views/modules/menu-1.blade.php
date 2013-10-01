@foreach($items as $item)
@if (is_array($item))
@foreach($item as $sub_item)
<div class="box box-pad-4 border-bottom-1">{{ $sub_item }}</div>
@endforeach
@else
<div class="box box-pad-0 border-bottom-1">{{ $item }}</div>
@endif
@endforeach
