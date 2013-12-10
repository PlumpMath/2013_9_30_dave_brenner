<?php

class LateSignUpController extends ResourceController
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
            	if (isset($resource['email'])) {
            		$name = $resource['email'];
            	} else {
            		$user = User::find($resouce['user_id']);

            		$name = $user->email;
            	}

            	if (isset($resource['child_name'])) {
            		$info = $resource['child_name'];
            	} else {
            		$child = Child::find($resource['child_id']);

            		$info = $child->name;
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
    	if (isset($resource['email'])) {
    		$name = $resource['email'];
    	} else {
    		$user = User::find($resouce['user_id']);

    		$name = $user->email;
    	}

    	return $name;
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
    	if (isset($resource['child_name'])) {
    		$info = $resource['child_name'];
    	} else {
    		$child = Child::find($resource['child_id']);

    		$info = $child->name;
    	}

        return $info;
    }

    // }}}

    public function create()
    {
        $data = array_merge($this->data, [
            'fields' => [
                [
                    'name' => 'email',
                    'type' => 'text',
                    'label' => 'User Email',
                ],
                [
                    'name' => 'child_name',
                    'type' => 'text',
                    'label' => 'Child\'s Name',
                ],
                [
                    'name' => 'lesson_id',
                    'type' => 'text',
                    'label' => 'Lesson ID',
                ],
            ],
        ]);

        return View::make('create.latesignup', $data);
    }
}
