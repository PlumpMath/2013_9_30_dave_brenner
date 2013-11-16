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
}
