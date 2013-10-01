<?php

// {{{ Verification

class Verification extends Resource {

	// {{{ properties

    protected $guarded = [];

    public static $rules = [];

    protected $relations_to = [
        'User',
    ];

    // }}}
    // {{{ user

    public function user()
    {
    	return $this->belongsTo('User');
    }

    // }}}
}

// }}}
