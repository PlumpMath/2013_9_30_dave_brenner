<?php

class Activity extends Resource {
    public $timestamps = false;
    
    protected $guarded = array();

    public static $rules = array();

    protected $relations_to = [
    	'Location',
    	'Lesson',
    ];

    public function locations()
    {
    	return $this->belongsToMany('Location');
    }

    public function lessons()
    {
    	return $this->hasMany('Lesson');
    }
}