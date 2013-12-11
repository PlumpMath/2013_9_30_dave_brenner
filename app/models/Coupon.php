<?php

class Coupon extends Resource {
    protected $guarded = [];

    public static $rules = [
		'code' =>'',
		'user_id' =>'',
		'price' =>'',
		'expires_on' =>'',
    ];

    protected $relations_to = [
        'User',
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }
}
