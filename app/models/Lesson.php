<?php

class Lesson extends Resource {
    protected $guarded = [];

    public static $rules = [
    ];

    protected $relations_to = [
        'LessonDate',
        'Location',
        'Children',
        'LateSignUp',
        'Activity',
        'LessonRestriction',
    ];

    public function activity()
    {
        return $this->belongsTo('Activity');
    }

    public function late_sign_up()
    {
        return $this->hasMany('LateSignUp');
    }

    public function dates()
    {
        return $this->hasMany('LessonDate');
    }

    public function location()
    {
        return $this->belongsTo('Location');
    }

    public function children()
    {
        return $this->belongsToMany('Children');
    }

    public function restrictions()
    {
        return $this->belongsToMany('LessonRestriction');
    }

    public function order()
    {
        return $this->hasMany('Order');
    }
}