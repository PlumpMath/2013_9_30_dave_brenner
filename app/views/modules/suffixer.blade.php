@if ($value == 1)
	{{ $value }}<sup>st</sup>
@elseif ($value == 2)
	{{ $value }}<sup>nd</sup>
@elseif ($value == 3)
	{{ $value }}<sup>rd</sup>
@else
	{{ $value }}<sup>th</sup>
