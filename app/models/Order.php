<?php

class Order extends Resource {
    protected $guarded = [];

    public static $rules = [
    ];

    protected $relations_to = [
        'Lesson',
        'User',
        'Child'
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function child()
    {
        return $this->belongsTo('Child');
    }

    public function lesson()
    {
        return $this->belongsTo('Lesson');
    }
}