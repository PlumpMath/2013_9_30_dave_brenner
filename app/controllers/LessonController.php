<?php

class LessonController extends ResourceController
{
    public function __construct()
    {
        parent::__construct();

        $this->url = [
            'log_out'   => URL::to('/log/out'),
            'home'      => URL::to('/'),
            'index'     => action($this->ResourceController.'@index'),
            'create'    => action($this->ResourceController.'@precreate'),
            'store'     => action($this->ResourceController.'@store'),
        ];

        $this->data['url'] = $this->url;
    }

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
                $activity = Activity::find($resource['activity_id']);
                $session = $resource['session_id'];

                $lesson = Lesson::find($resource['id']);
                $year = $lesson->firstLesson()->format('Y');
                $day = $lesson->day();
                $time = $lesson->starts();

                $restrictions = $lesson->restrictions()->get();
                $rs = [];

                foreach($restrictions as $restriction) {
                    $rs[] = $restriction->value;
                }

                sort($rs);


                $grades = '';
                $ordinals = ['st', 'nd', 'rd', 'th'];

                foreach ($rs as $restriction) {
                    $o = ($restriction > 4) ? 4 : $restriction;
                    if ($o > 0)
                        $grades .= $restriction.$ordinals[$o-1].'/';
                }

                $grades = trim($grades, '/');

                if ( ! is_null($location) && ! is_null($activity) && ! is_null($lesson) && ! is_null($lesson->dates()->first())) {
                    $name = $activity->name.', '.$location->city;
                    $info = $session.' '.$year.', '.$day.' '.$time.'  '.$grades;
                } else {
                    $name = 'Missing info.';
                    $info = $session;
                }

                $__output[] = [
                    'name'  => $name,
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
        $location = Location::find($resource['location_id']);
        $activity = Activity::find($resource['activity_id']);

        if ( ! is_null($location) && ! is_null($activity)) {
            return $activity->name.', '.$location->city;
        } else {
            return 'Missing info.';
        }
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
        $session = $resource['session_id'];

        $lesson = Lesson::find($resource['id']);

        if (is_null($lesson->dates()->first())) return 'Missing info.';

        $year = $lesson->firstLesson()->format('Y');
        $day = $lesson->day();
        $time = $lesson->starts();

        $grades = '';
        $restrictions = $lesson->restrictions()->get();
        $rs = [];

        foreach($restrictions as $restriction) {
            $rs[] = $restriction->value;
        }

        sort($rs);


        $ordinals = ['st', 'nd', 'rd', 'th'];


        foreach ($rs as $restriction) {
            $o = ($restriction > 4) ? 4 : $restriction;
            if ($o > 0)
                $grades .= $restriction.$ordinals[$o-1].'/';
        }

        $grades = trim($grades, '/');

        if ( ! is_null($lesson)) {
            return $session.' '.$year.', '.$day.' '.$time.'  '.$grades;
        } else {
            return $session;
        }
    }

    // }}}

    public function index()
    {
        if (Input::has('user')) {
            $user = Input::get('user');
            $lessons = User::find(+$user)->lessons();
        } else if (Input::has('location')) {
            $location = Input::get('location');
            $lessons = Location::find($location)->lessons()->get();
        } else if (Input::has('child')) {
            $child = Input::get('child');
            $lessons = Child::find($child)->lessons()->get();
        } else if (Input::has('activity')) {
            $activity = Input::get('activity');
            $lessons = Activity::find($activity)->lessons()->get();
        } else {
            $lessons = Lesson::all();
        }

        $__output = [];

        foreach ($lessons as $lesson) {
            array_unshift($__output, $lesson);
        }

        $data = array_merge($this->data, [
            'resources'  => ($this->format($__output)->forDisplay()),
            'date' => 'none',
        ]);

        return View::make('resource.index', $data);
    }

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
            'edit'   => action($this->ResourceController.'@preedit', $id),
            'receipts' => action('ReceiptController@index'),
            'children' => action('ChildController@index'),
            'users' => action('UserController@index'),
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
            'url' => [
            	'create' => URL::action('LessonController@create'),
            ]
        ]);

        return View::make('create.prelesson', $data);
    }

    public function preedit($id)
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
            'url' => [
                'edit' => URL::action('LessonController@edit', $id)
            ],
        ]);

        return View::make('edit.prelesson', $data);
    }

    public function edit($id)
    {
        $lesson = Lesson::find($id);
        $l_dates = $lesson->dates()->get();
        $l_restrictions = $lesson->restrictions()->get();

        $dates = [];
        $old = [
            'location_id' => $lesson->location_id,
            'activity_id' => $lesson->activity_id,
            'section_id' => $lesson->section_id,
            'previous_id' => $lesson->previous_id,
            'spots' => $lesson->spots,
            'price' => $lesson->price,
            'provider' => $lesson->provider,
            'session_id' => $lesson->session_id,
            'status' => $lesson->status,
        ];
        $restrictions = [];

        for ($i = 0; $i < count($l_dates); $i++) {
            $dates = array_merge([
                'break_'.$i => 'break',
                [
                    'name' => 'lesson_date_'.$i.'_lesson_date_template_id',
                    'type' => 'text',
                    'label' => 'Template ID',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_name',
                    'type' => 'text',
                    'label' => 'Name',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_description',
                    'type' => 'text',
                    'label' => 'Description',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_starts_on',
                    'type' => 'text',
                    'label' => 'Starts',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_ends_on',
                    'type' => 'text',
                    'label' => 'Ends',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_id',
                    'type' => 'hidden',
                    'label' => '',
                ],            
            ], $dates);

            $old = array_merge([
                'lesson_date_'.$i.'_lesson_date_template_id' => $l_dates[$i]->lesson_date_template_id,
                'lesson_date_'.$i.'_name' => $l_dates[$i]->name,
                'lesson_date_'.$i.'_description' => $l_dates[$i]->description,
                'lesson_date_'.$i.'_starts_on' => $l_dates[$i]->starts_on,
                'lesson_date_'.$i.'_ends_on' => $l_dates[$i]->ends_on,
                'lesson_date_'.$i.'_id' => $l_dates[$i]->id,           
            ], $old);
        }

        for ($i = count($l_dates); $i < count($l_dates)+Input::get('dates'); $i++) {
            $dates = array_merge([
                'break_'.$i => 'break',
                [
                    'name' => 'lesson_date_'.$i.'_lesson_date_template_id',
                    'type' => 'text',
                    'label' => 'Template ID',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_name',
                    'type' => 'text',
                    'label' => 'Name',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_description',
                    'type' => 'text',
                    'label' => 'Description',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_starts_on',
                    'type' => 'text',
                    'label' => 'Starts',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_ends_on',
                    'type' => 'text',
                    'label' => 'Ends',
                ],           
            ], $dates);
        }
/**/
        for ($i = 0; $i < count($l_restrictions); $i++) {
            $restrictions = array_merge([
                [
                    'name' => 'lesson_restriction_'.$i.'_value',
                    'type' => 'text',
                    'label' => 'Grade',
                ],
                [
                    'name' => 'lesson_restriction_'.$i.'_id',
                    'type' => 'hidden',
                    'label' => '',
                ],
            ], $restrictions);

            $old = array_merge([
                'lesson_restriction_'.$i.'_value' => $l_restrictions[$i]->value,
                'lesson_restriction_'.$i.'_id' => $l_restrictions[$i]->id,  
            ], $old);
        }

        for ($i = count($l_restrictions); $i < count($l_restrictions)+Input::get('restrictions'); $i++) {
            $restrictions = array_merge([
                [
                    'name' => 'lesson_restriction_'.$i.'_value',
                    'type' => 'text',
                    'label' => 'Grade',
                ]
            ], $restrictions);
        }
/**/
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
                [
                    'name' => 'provider',
                    'type' => 'text',
                    'label' => 'Provider',
                ],
                [
                    'name' => 'session_id',
                    'type' => 'text',
                    'label' => 'Session',
                ],
                [
                    'name' => 'status',
                    'type' => 'text',
                    'label' => 'status',
                ],
            ],
            'dates' => $dates,
            'lesson_dates' => count($l_dates)+Input::get('dates'),
            'restrictions' => $restrictions,
            'lesson_restrictions' => count($l_restrictions)+Input::get('grades'),
            'url' => [
                'update' => URL::action('LessonController@update', $id)
            ],
            'old' => (Session::has('_old_input')) ? Session::get('_old_input') : $old,
        ]);

        return View::make('edit.lesson', $data);
    }

    public function update($id)
    {
        $lesson_dates_number = Input::get('lesson_date_number');
        $lesson_restrictions_number = Input::get('lesson_restriction_number');

        $data = [
        	'section_id' => Input::get('section_id'),
        	'session_id' => Input::get('session_id'),
        	'spots' => Input::get('spots'),
        	'price' => Input::get('price'),
        	'provider' => Input::get('provider'),
        	'status' => Input::get('status'),
        ];

        $rules = [
        	'section_id' => 'integer',
        	'spots' => 'required|integer',
        	'price' => 'required|numeric',
        	'status' => 'required|integer',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
	        $lesson = Lesson::find($id);
	        $location = Location::find(Input::get('location_id'));
	        $activity = Activity::find(Input::get('activity_id'));

	        $location->lessons()->save($lesson);
	        $activity->lessons()->save($lesson);

	        $lesson->section_id = Input::get('section_id');
	        $lesson->previous_id = Input::get('previous_id');
	        $lesson->spots = Input::get('spots');
	        $lesson->price = Input::get('price');

		        $lesson->provider = Input::get('provider');
		        $lesson->status = Input::get('status');
		        $lesson->session_id = Input::get('session_id');

	        for ($i = 0; $i < $lesson_dates_number; $i++) {
	            if (Input::has('lesson_date_'.$i.'_id')) {
	                $lesson_date = LessonDate::find(Input::get('lesson_date_'.$i.'_id'));
	            } else {
	                $lesson_date = new LessonDate;
	            }

	            $lesson_date->lesson_date_template_id = Input::get('lesson_date_'.$i.'_lesson_date_template_id');
	            $lesson_date->name = Input::get('lesson_date_'.$i.'_name');
	            $lesson_date->description = Input::get('lesson_date_'.$i.'_description');
	            $lesson_date->starts_on = (new DateTime(Input::get('lesson_date_'.$i.'_starts_on')))->format('Y-m-d H:i:s');
	            $lesson_date->ends_on = (new DateTime(Input::get('lesson_date_'.$i.'_ends_on')))->format('Y-m-d H:i:s');
	            $lesson_date->lesson_id = $lesson->id;

	            $lesson_date->save();
	        }

	        for ($i = 0; $i < $lesson_restrictions_number; $i++) {
	            if (Input::has('lesson_restriction_'.$i.'_id')) {
	                $lesson_restriction = LessonRestriction::find(Input::get('lesson_restriction_'.$i.'_id'));
	            } else {
	                $lesson_restriction = new LessonRestriction;
                    $lesson_restriction->lessons()->attach($lesson->id);
	            }

	            $lesson_restriction->property = 'grade';
	            $lesson_restriction->comparison = '=';
	            $lesson_restriction->value = Input::get('lesson_restriction_'.$i.'_value');

	            $lesson_restriction->save();
	        }

	        $lesson->save();

	        return Redirect::action('LessonController@show', $lesson->id);
    	} else {
    		return Redirect::action('LessonController@edit', $id)->withInput(Input::all())->withErrors($validator);
    	}
    }

    public function store()
    {
        $lesson_dates_number = Input::get('lesson_date_number');
        $lesson_restrictions_number = Input::get('lesson_restriction_number');

        $data = [
        	'section_id' => Input::get('section_id'),
        	'session_id' => Input::get('session_id'),
        	'spots' => Input::get('spots'),
        	'price' => Input::get('price'),
        	'provider' => Input::get('provider'),
        	'status' => Input::get('status'),
        ];

        $rules = [
        	'section_id' => 'integer',
        	'spots' => 'required|integer',
        	'price' => 'required|numeric',
        	'status' => 'required|integer',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->passes()) {
	        $lesson = new Lesson;
	        $location = Location::find(Input::get('location_id'));
	        $activity = Activity::find(Input::get('activity_id'));

	        $location->lessons()->save($lesson);
	        $activity->lessons()->save($lesson);

	        $lesson->section_id = Input::get('section_id');
	        $lesson->previous_id = Input::get('previous_id');
	        $lesson->spots = Input::get('spots');
	        $lesson->price = Input::get('price');

	        $lesson->provider = Input::get('provider');
	        $lesson->status = Input::get('status');
	        $lesson->session_id = Input::get('session_id');
 
	        for ($i = 0; $i < $lesson_dates_number; $i++) {
	            $lesson_date = new LessonDate;

	            $lesson_date->lesson_date_template_id = Input::get('lesson_date_'.$i.'_lesson_date_template_id');
	            $lesson_date->name = Input::get('lesson_date_'.$i.'_name');
	            $lesson_date->description = Input::get('lesson_date_'.$i.'_description');
	            $lesson_date->starts_on = (new DateTime(Input::get('lesson_date_'.$i.'_starts_on')))->format('Y-m-d H:i:s');
	            $lesson_date->ends_on = (new DateTime(Input::get('lesson_date_'.$i.'_ends_on')))->format('Y-m-d H:i:s');
	            $lesson_date->lesson_id = $lesson->id;

	            $lesson_date->save();
	        }

	        for ($i = 0; $i < $lesson_restrictions_number; $i++) {
	            $lesson_restriction = new LessonRestriction;

	            $lesson_restriction->property = 'grade';
	            $lesson_restriction->comparison = '=';
	            $lesson_restriction->value = Input::get('lesson_restriction_'.$i.'_value');

	            $lesson_restriction->save();

	            $lesson_restriction->lessons()->attach($lesson->id);
	        }

	        $lesson->save();

	        return Redirect::action('LessonController@show', $lesson->id);
    	} else {
    		return Redirect::action('LessonController@create')->withInput(Input::all())->withErrors($validator);
    	}
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
                    'name' => 'lesson_date_'.$i.'_name',
                    'type' => 'text',
                    'label' => 'Name',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_description',
                    'type' => 'text',
                    'label' => 'Description',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_starts_on',
                    'type' => 'text',
                    'label' => 'Starts',
                ],
                [
                    'name' => 'lesson_date_'.$i.'_ends_on',
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
                [
                    'name' => 'provider',
                    'type' => 'text',
                    'label' => 'Provider',
                ],
                [
                    'name' => 'session_id',
                    'type' => 'text',
                    'label' => 'Session',
                ],
                [
                    'name' => 'status',
                    'type' => 'text',
                    'label' => 'status',
                ],
            ],
            'dates' => $dates,
            'lesson_dates' => +Input::get('dates'),
            'restrictions' => $restrictions,
            'lesson_restrictions' => +Input::get('grades'),
            'old' => (Session::has('_old_input')) ? Session::get('_old_input') : [],
        ]);

        return View::make('create.lesson', $data);
    }
}
