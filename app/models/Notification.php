<?php

// {{{ Notification

class Notification extends Resource {

	// {{{ properties

    protected $guarded = [];

    public static $rules = [];

    protected $relations_to = [
        'User',
    ];

    // }}}
    // {{{ user

    public function users()
    {
    	return $this->belongsToMany('User');
    }

    // }}}
}

// }}}
