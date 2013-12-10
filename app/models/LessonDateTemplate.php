<?php

class LessonDateTemplate extends Resource {
    public $timestamps = false;
    
    protected $guarded = [];

    public static $rules = [
    	'name' => 'required',
    	'description' => 'required',
    ];

    protected $relations_to = [
        'LessonDate',
    ];

    public function lesson_dates()
    {
        return $this->hasMany('LessonDate');
    }
}