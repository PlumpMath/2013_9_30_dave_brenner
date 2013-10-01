<?php

class LessonDate extends Resource {
    protected $guarded = [];

    public static $rules = [
    ];

    protected $relations_to = [
        'Lesson',
        'LessonDateTemplate',
    ];

    public function lesson()
    {
        return $this->belongsTo('Lesson');
    }

    public function template()
    {
        return $this->belongsTo('LessonDateTemplate');
    }
}