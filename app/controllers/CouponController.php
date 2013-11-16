<?php

class CouponController extends ResourceController
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
                $__output[] = [
                    'name'  => 'Coupon for '.$user->first_name.' '.$user->last_name,
                    'id'    => $resource['id'],
                    'info'  => $resource['price'],
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
        $user = User::find($resource['user_id']);
        return 'Coupon for '.$user->first_name.' '.$user->last_name;
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
        return $resource['price'];
    }

    // }}}
}
