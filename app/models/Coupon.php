<?php

class Coupon extends Resource {
    protected $guarded = [];

    public static $rules = [
    ];

    protected $relations_to = [
        'User',
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }
}
