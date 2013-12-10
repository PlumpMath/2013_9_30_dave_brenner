<?php

class Receipt extends Resource {
    protected $guarded = [];

    public static $rules = [
    	'confirmation_id' => '',
    	'user_id' => '',
    	'lesson_id' => '',
    	'child_id' => '',
    	'coupon_id' => '',
    ];

    protected $relations_to = [
        'Lesson',
        'User',
        'Child',
        'Coupon'
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

    public function coupon()
    {
        return $this->belongsTo('Coupon');
    }
}