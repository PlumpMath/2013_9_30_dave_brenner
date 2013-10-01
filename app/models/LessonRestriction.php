<?php

class LessonRestriction extends Resource {
    public $timestamps = false;

    protected $guarded = [];

    public static $rules = [
    ];

    protected $relations_to = [
        'Lesson',
    ];

    public function lessons()
    {
        return $this->belongsToMany('lessons');
    }
}