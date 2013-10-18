<?php

// {{{ Waitlist

class Waitlist extends Resource {

	// {{{ properties

    protected $guarded = [];

    public static $rules = [];

    protected $relations_to = [
        'User',
        'Child',
    ];

    // }}}
    // {{{ user

    public function users()
    {
    	return $this->belongsToMany('User');
    }

    // }}}
    // {{{ children

    public function children()
    {
        return $this->belongsToMany('Child');
    }

    // }}}
    // {{{ lesson

    public function lesson()
    {
        return $this->belongsTo('Lesson');
    }

    // }}}
}

// }}}
