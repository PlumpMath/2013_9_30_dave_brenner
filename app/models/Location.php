<?php

// {{{ Location

class Location extends Resource {

	// {{{ properties

    protected $guarded = [];

    public static $rules = [];

    protected $relations_to = [
    	'Activity',
        'Lesson',
    ];

    // }}}

    public function activities()
    {
    	return $this->belongsToMany('Activity');
    }

    public function lessons()
    {
        return $this->hasMany('Lesson');
    }
}

// }}}
