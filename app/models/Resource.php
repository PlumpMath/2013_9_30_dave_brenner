<?php

// {{{ Resource

class Resource extends Eloquent {
 
    // {{{ properties

    public static $rules = [];

    protected $relations_to;

    // }}}
    // {{{ relations

    /**
     * Gets models this model is related to
     *
     * @return array    array containing strings of models
     */

    public function relations()
    {
    	return $this->relations_to;
    }

    // }}}
}

// }}}
