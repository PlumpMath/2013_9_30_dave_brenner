<?php

class UserController extends ResourceController
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
                $__output[] = [
                    'name'  => $resource['email'],
                    'id'    => $resource['id'],
                    'info'  => $resource['first_name'].' '.$resource['last_name'],
                ];
            }
        } else {
            //bin holds one location
            foreach ($this->bin['resource'] as $key => $value) {
                switch ($key) {
                    case 'phone':
                        $value = '('.substr($value, 0, 3).') '.substr($value, 3, 3).'-'.substr($value, 6, 4);
                        break;
                    case 'status':
                        $value = ($value === 1) ? 'Active' : 'Inactive';
                        break;
                    case 'notes':
                        $value = (is_null($value)) ? 'No Notes' : $value;
                        break;
                }

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
        return $resource['name'];
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
        return $resource['first_name'].' '.$resource['last_name'];
    }

    // }}}
}
