@extends('layouts.email')

@section('content')
<h1 style="display: block; font-family: 'Open Sans'; font-size: 26px; font-style: normal; font-weight: bold; line-height: 100%; letter-spacing: normal; margin: 0px 0px 10px; text-align: left; color: rgb(82, 82, 82);">Hi, {{{ $user_name }}}</h1>
<h3 style="display: block; font-family: 'Open Sans'; font-size: 16px; font-style: italic; font-weight: normal; line-height: 100%; letter-spacing: normal; margin: 0px 0px 10px; text-align: left; color: rgb(149, 149, 149);">It looks like you just signed up for classes.  Great!  Here’s what we have:</h3>
<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody" style="border-collapse: collapse; padding: 20px; background-color: rgb(255, 255, 255); border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(208, 208, 208);">
<tbody><tr>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 14px; padding-right: 20px; line-height: 150%;text-align: left;">
Student
</td>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(248, 108, 89); font-family: 'Open Sans'; font-size: 14px; line-height: 150%; text-align: left;">
{{{ $student }}}
</td>
</tr><tr>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 14px; padding-right: 20px; line-height: 150%; text-align: left;">
Location
</td>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(248, 108, 89); font-family: 'Open Sans'; font-size: 14px; line-height: 150%; text-align: left;">
{{ $location }}<br />{{ $address.' '.$phone }}
</td>
</tr><tr>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 14px; padding-right: 20px; line-height: 150%; text-align: left;">
Activity
</td>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(248, 108, 89); font-family: 'Open Sans'; font-size: 14px; line-height: 150%; text-align: left;">
{{ $activity }}
</td>
</tr><tr>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 14px; padding-right: 20px; line-height: 150%; text-align: left;">
Session
</td>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(248, 108, 89); font-family: 'Open Sans'; font-size: 14px; line-height: 150%; text-align: left;">
{{ $session }}
</td>
</tr><tr>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 14px; padding-right: 20px; line-height: 150%; text-align: left;">
Day
</td>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(248, 108, 89); font-family: 'Open Sans'; font-size: 14px; line-height: 150%; text-align: left;">
{{ $day }}
</td>
</tr><tr>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 14px; padding-right: 20px; line-height: 150%; text-align: left;">
Time
</td>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(248, 108, 89); font-family: 'Open Sans'; font-size: 14px; line-height: 150%; text-align: left;">
{{ $time }}
</td>
</tr><tr>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 14px; padding-right: 20px; line-height: 150%; text-align: left;">
Class
</td>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(248, 108, 89); font-family: 'Open Sans'; font-size: 14px; line-height: 150%; text-align: left;">
{{ $class }}
</td>
</tr><tr>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(149, 149, 149); font-family: 'Open Sans'; font-size: 14px; padding-right: 20px; line-height: 150%; text-align: left;">
Dates
</td>
<td valign="top" class="bodyContent" mc:edit="body_content" style="color: rgb(248, 108, 89); font-family: 'Open Sans'; font-size: 14px; line-height: 150%; text-align: left;">
{{ $dates }}
</td>
</tr>
</tbody></table> 
<br />If everything looks right, you are done!  Just show up on the first day of classes about 5 minutes early.<br /><br />If anything does not look correct, don’t worry we can take care of it, but please call us immediately so we can fix it.<br /><br />If for any reason your class does not fill, we will contact you (we can try to find another class that suits your needs at that time).<br /><br />Thanks and enjoy the program!
@stop
