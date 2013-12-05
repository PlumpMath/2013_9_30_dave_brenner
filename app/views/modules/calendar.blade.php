<table class="calendar small" id="#Calendar{{ $calendar->config['id'] }}">
    <thead>
        <tr class="navigation">
            <th class="prev-month"><a href="{{ htmlspecialchars($calendar->prev_month_url()) }}#Calendar{{ $calendar->config['id'] }}">{{ $calendar->prev_month(0, '&laquo;') }}</a></th>
            <th colspan="5" class="current-month">{{ $calendar->month() }} {{ $calendar->year }}</th>
            <th class="next-month"><a href="{{ htmlspecialchars($calendar->next_month_url()) }}#Calendar{{ $calendar->config['id'] }}">{{ $calendar->next_month(0, '&raquo;') }}</a></th>
        </tr>
        <tr class="weekdays">
            @foreach ($calendar->days(1) as $day)
                <th>{{ $day }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($calendar->weeks() as $week)
            <tr>
                @foreach ($week as $day)
                    <?php
                    list($number, $current, $data) = $day;
                     
                    $classes = array();
                    $output  = '';
                     
                    if (is_array($data))
                    {
                        $classes = $data['classes'];
                        $title   = $data['title'];
                        $output  = empty($data['output']) ? '' : '<ul class="output"><li>'.implode('</li><li>', $data['output']).'</li></ul>';
                    }
                    ?>
                    <td class="day {{ implode(' ', $classes) }}">
                        <span class="date" title="{{ implode(' / ', $title) }}">
                            @if ( ! empty($output))
                                <a href="#" class="view-events">{{ $number }}</a>
                            @else
                                {{ $number }}
                            @endif
                        </span>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>