<?php

class ReceiptController extends ResourceController
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
                $user = User::find($resource['user_id']);
                $child = Child::find($resource['child_id']);

                if ( ! is_null($child) && ! is_null($user)) {
                    $__output[] = [
                        'name'  => $resource['confirmation_id'],
                        'id'    => $resource['id'],
                        'info'  => '<span class="bold">'.$resource['created_at'].'</span> Receipt for '.$user->first_name.' '.$user->last_name.'\'s child, '.$child->first_name,
                    ];
                } else {
                    $__output[] = [
                        'name'  => $resource['confirmation_id'],
                        'id'    => $resource['id'],
                        'info'  => '<span class="bold">'.$resource['created_at'].'</span>',
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
        return $resource['confirmation_id'];
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
        $user = User::find($resource['user_id']);
        $child = Child::find($resource['child_id']);

        if ( ! is_null($child) && ! is_null($user)) {
            return '<span class="bold">'.$resource['created_at'].'</span> Receipt for '.$user->first_name.' '.$user->last_name.'\'s child, '.$child->first_name;
        } else {
            return '<span class="bold">'.$resource['created_at'].'</span>';
        }
    }

    // }}}
    // {{{ index

    /**
     * ResourceController@index  
     *
     * A view containing an index of all resources
     * Available at url: /resource
     *
     * @return  View    resource.index
     */

    public function index()
    {
        if (Input::has('user')) {
            $user = Input::get('user');
            $receipts = User::find($user)->receipts()->get();
        } else if (Input::has('location')) {
            $location = Input::get('location');
            $receipts = Location::find($location)->receipts()->get();
        } else if (Input::has('lesson')) {
            $lesson = Input::get('lesson');
            $receipts = Lesson::find($lesson)->receipts()->get();
        } else if (Input::has('child')) {
            $child = Input::get('child');
            $receipts = Child::find($child)->receipts()->get();
        } else if (Input::has('activity')) {
            $activity = Input::get('activity');
            $receipts = Activity::find($activity)->receipts()->get();
        } else {
            $receipts = Receipt::all();
        }

        $__output = [];

        foreach ($receipts as $receipt) {
            array_unshift($__output, $receipt);
        }

        $data = array_merge($this->data, [
            'resources'  => ($this->format($__output)->forDisplay()),
            'date' => 'none',
        ]);

        return View::make('resource.index', $data);
    }

    // }}}
}
