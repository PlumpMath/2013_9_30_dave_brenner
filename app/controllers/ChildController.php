<?php

class ChildController extends ResourceController
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
                $parent = User::find($resource['user_id']);

                if ($parent) {
                    $__output[] = [
                        'name'  => $resource['first_name'].' '.$resource['last_name'],
                        'id'    => $resource['id'],
                        'info'  => 'Child of '.$parent->first_name.' '.$parent->last_name,
                    ];
                }   
                else {
                    $__output[] = [
                        'name'  => $resource['first_name'].' '.$resource['last_name'],
                        'id'    => $resource['id'],
                        'info'  => 'Parent-less',
                    ];
                }
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
        return $resource['first_name'].' '.$resource['last_name'];
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
        $parent = User::find($resource['user_id']);
        if ($parent) {
            return 'Child of '.$parent->first_name.' '.$parent->last_name;
        } else {
            return 'Parent-less';
        }
    }

    // }}}

    public function index()
    {
        if (Input::has('user')) {
            $user = Input::get('user');
            $children = User::find($user)->children();
        } else if (Input::has('lesson')) {
            $lesson = Input::get('lesson');
            $children = Lesson::find($lesson)->children()->get();
        } else {
            $children = Child::all();
        }

        $__output = [];

        foreach ($children as $child) {
            array_unshift($__output, $child);
        }

        $data = array_merge($this->data, [
            'resources'  => ($this->format($__output)->forDisplay()),
            'date' => 'none',
        ]);

        return View::make('resource.index', $data);
    }

    public function show($id)
    {
        $ModelName = $this->Resource;
        $resource_to_show = $ModelName::find($id)->toArray();

        $url = array_merge($this->url, [
            'copy'   => action($this->ResourceController.'@copy', $id),
            'delete' => action($this->ResourceController.'@destroy', $id),
            'edit'   => action($this->ResourceController.'@edit', $id),
            'receipts' => action('ReceiptController@index'),
            'lessons' => action('LessonController@index'),
            'user' => action('UserController@index'),
        ]);

        $data = array_merge($this->data, [
            'name'          => $this->name($resource_to_show),
            'info'          => $this->info($resource_to_show),
            'resource'      => $this->format($resource_to_show)->forDisplay(),
            'resource_id'   => $id,
            'input_name'    => $this->resource,
            'url'           => $url,
        ]);
        
        return View::make('show.children', $data);
    }
}
