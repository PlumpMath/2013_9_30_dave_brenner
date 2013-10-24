<?php

class Receipt extends Resource {
    protected $guarded = [];

    public static $rules = [
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