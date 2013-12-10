<?php

class LateSignUp extends Resource {
    protected $guarded = [
    	'user_id',
    	'class_session_id'
    ];

    public static $rules = [
        'lesson_id'     => 'required',
        'email'         => 'required_without:user_id|email',
        'user_id'       => 'required_without:email|integer',
        'child_name'    => 'required_without:child_id',
        'child_id'      => 'required_without:child_name|integer',
    ];

    protected $table = 'latesignups';

    protected $relations_to = [
    	'User',
    	'ClassSession',
        'Lesson',
    ];

    public static function existsForUser($user)
    {
    	$response = $user->latesignups()->get();

    	if ( ! empty($response)) return true;

    	$latesignups = LateSignUp::all();

    	foreach ($latesignups as $latesignup) {
    		if ($latesignup->user_id == $user->id
    			|| $latesignup->email == $user->email) return true;
    	}

    	return false;
    }

    public static function getChildrenFromUser($user)
    {
    	$children = $user->children()->get();
    	$__output = [];

    	if ( ! empty($user->latesignups()->get())) {
    		$latesignups = $user->latesignups()->get();
    	} else {
    		$all = LateSignUp::all();
    		$latesignups = [];

	    	foreach ($all as $latesignup) {
	    		if ($latesignup->user_id == $user->id
	    			|| $latesignup->email == $user->email) $latesignups[] = $latesignup;
	    	}
    	}


    	foreach ($children as $child) {
    		foreach ($latesignups as $latesignup) {
    			if ($latesignup->child_id == $child->id
    				|| $latesignup->child_name == $child->first_name) $__output[] = $child;
    		}
    	}

    	return $__output;
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function lesson()
    {
        return $this->belongsTo('Lesson');
    }
}