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

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function lesson()
    {
        return $this->belongsTo('Lesson');
    }
}