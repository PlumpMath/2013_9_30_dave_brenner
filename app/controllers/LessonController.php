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

                if ( ! is_null($location)) $info = $location->address;
                else $info = 'Location appears to be deleted.';
                $__output[] = [
                    'name'  => $resource['price'],
                    'id'    => $resource['id'],
                    'info'  => $info,
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

        if ( ! is_null($location)) return $location->address;
        else return 'Location appears to be deleted.';
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

        $url = array_merge($this->url, [
            'copy'   => action($this->ResourceController.'@copy', $id),
            'delete' => action($this->ResourceController.'@destroy', $id),
            'edit'   => action($this->ResourceController.'@edit', $id),
            'receipts' => action('ReceiptController@index'),
        ]);

        $data = array_merge($this->data, [
            'name'      => $this->name($resource_as_array),
            'info'      => $this->info($resource_as_array),
            'resource'  => $this->format($resource_as_array)->forDisplay(),
            'dates'     => $dates,
            'resource_id'   => $id,
            'input_name'    => $this->resource,
            'url'       => $url,
        ]);
        
        return View::make('show.lessons', $data);
    }

    public function precreate()
    {
        $data = array_merge($this->data, [
            'fields' => [
                [
                    'name' => 'dates',
                    'type' => 'text',
                    'label' => 'Number of Dates',
                ],
                [
                    'name' => 'grades',
                    'type' => 'text',
                    'label' => 'Number of Grades',
                ],
            ],
        ]);

        return View::make('create.prelesson', $data);
    }

    public function store()
    {
        return;
    }

    public function create()
    {
        $dates = [];
        $restrictions = [];

        for ($i = 0; $i < +Input::get('dates'); $i++) {
            $dates = array_merge([
                'break_'.$i => 'break',  
                [
                    'name' => 'lesson_date_'.$i.'_lesson_date_template_id',
                    'type' => 'text',
                    'label' => 'Template ID',
                ],
                [
                    'name' => 'lesson_date_'.$i.'name',
                    'type' => 'text',
                    'label' => 'Name',
                ],
                [
                    'name' => 'lesson_date_'.$i.'description',
                    'type' => 'text',
                    'label' => 'Description',
                ],
                [
                    'name' => 'lesson_date_'.$i.'starts_on',
                    'type' => 'text',
                    'label' => 'Starts',
                ],
                [
                    'name' => 'lesson_date_'.$i.'ends_on',
                    'type' => 'text',
                    'label' => 'Ends',
                ],           
            ], $dates);
        }

        for ($i = 0; $i < +Input::get('grades'); $i++) {
            $restrictions = array_merge([
                [
                    'name' => 'lesson_restriction_'.$i.'_value',
                    'type' => 'text',
                    'label' => 'Grade',
                ]
            ], $restrictions);
        }

        $data = array_merge($this->data, [
            'fields' => [
                [
                    'name' => 'location_id',
                    'type' => 'text',
                    'label' => 'Location ID',
                ],
                [
                    'name' => 'activity_id',
                    'type' => 'text',
                    'label' => 'Activity ID',
                ],
                [
                    'name' => 'section_id',
                    'type' => 'text',
                    'label' => 'Section',
                ],
                [
                    'name' => 'previous_id',
                    'type' => 'text',
                    'label' => 'ID of Lesson preceding this one',
                ],
                [
                    'name' => 'spots',
                    'type' => 'text',
                    'label' => 'Number of Spots',
                ],
                [
                    'name' => 'price',
                    'type' => 'text',
                    'label' => 'Price',
                ],
            ],
            'dates' => $dates,
            'restrictions' => $restrictions,
        ]);

        return View::make('create.lesson', $data);
    }
}
