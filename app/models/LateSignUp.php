<?php

class LateSignUp extends Resource {
    protected $guarded = [
    	'user_id',
    	'class_session_id'
    ];

    public static $rules = [];

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