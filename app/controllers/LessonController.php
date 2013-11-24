<?php

class LessonController extends ResourceController
{
    // {{{ forDisplay

    /**
     * Formats data for display
     *
     * Expects to be chained with format  
     *
     * @return  array containing data for display
     */

    public function forDisplay()
    {
        $__output = [];

        if (isset($this->bin['resource'][0])) {
            //bin holds a list of all locations
            foreach ($this->bin['resource'] as $resource) {
                $location = Location::find($resource['location_id']);
                $__output[] = [
                    'name'  => $resource['price'],
                    'id'    => $resource['id'],
                    'info'  => $location->address,
                ];
            }
        } else {
            //bin holds one location
            foreach ($this->bin['resource'] as $key => $value) {
                $__output[$this->format($key)->asKey()] = $value;
            }            
        }

        return $__output;
    }

    // }}}
    // {{{ name

    /**
     * Gets a name value to use
     *
     * @return  name
     */

    public function name($resource)
    {
        return $resource['price'];
    }

    // }}}
    // {{{ info

    /**
     * Gets an info value
     *
     * @return  gets an info value
     */

    public function info($resource)
    {
        $location = Location::find($resource['location_id']);
        return $location->address;
    }

    // }}}

    public function show($id)
    {
        // special show for lessons

        // show all lessons dates after regular properties
        $ModelName = $this->Resource;
        $resource_to_show = $ModelName::find($id);
        $resource_as_array = $resource_to_show->toArray();

        $d = $resource_to_show->dates()->get();
        $dates = [];

        foreach ($d as $dd) {
            $template = LessonDateTemplate::find($dd->lesson_date_template_id);

            if ($dd->name) {
                $name = $dd->name;
            } else {
                $name = $template->name;
            }

            if ($dd->description) {
                $desc = $dd->description;
            } else {
                $desc = $template->description;
            }

            $starts = $dd->starts_on;
            $ends = $dd->ends_on;

            $dates[] = [
                'name'          => $name,
                'description'   => $desc,
                'starts'        => $starts,
                'ends'          => $ends,
            ];
        }

        $data = array_merge($this->data, [
            'name'      => $this->name($resource_as_array),
            'info'      => $this->info($resource_as_array),
            'resource'  => $this->format($resource_as_array)->forDisplay(),
            'dates'     => $dates,
        ]);
        
        return View::make('show.lessons', $data);
    }
}
