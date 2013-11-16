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
                $__output[] = [
                    'name'  => $resource['first_name'].' '.$resource['last_name'],
                    'id'    => $resource['id'],
                    'info'  => 'Child of '.$parent->first_name.' '.$parent->last_name,
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
        return 'Child of '.$parent->first_name.' '.$parent->last_name;
    }

    // }}}
}
