<?php

class Child extends Resource {
    protected $guarded = [];

    public static $rules = [
        'first_name'    	=> 'required',
        'last_name'     	=> 'required',
        'school'        	=> 'required',
        'birthday'      	=> 'required|date',
        'age'      			=> 'required|numeric|max:20|min:4',
        'grade'       		=> 'required|numeric',
        'gender'          	=> 'required|in:male,female',
        'returning_player'  => 'required|in:1,0',
    ];

    protected $relations_to = [
        'User',
        'Lesson',
        'Order',
        'Receipt',
    ];

    public static function getBirthday($str)
    {
        if ( ! preg_match('/\d*\/\d*\/\d*/', $str)) return $str;
    	$birthdate = explode('/', $str);

    	return date('Y-m-d H:i:s', mktime(0, 0, 0, $birthdate[0], $birthdate[1], $birthdate[2]));
	}

    public static function getAge($str)
    {
        if ( ! preg_match('/\d*\/\d*\/\d*/', $str)) return $str;
        
    	$birthdate = explode('/', $str);

    	return ((+date("Y"))-(+$birthdate[2]));
    }

    public static function getGrade($birthdate, $age)
    {
        if ((new DateTime($birthdate))->format('m') === '12') {
            $grade = $age-5;
        } else {
            $grade = $age-4;
        }

        return min(max($grade, 1), 12);
    }

    public static function young() {
    	return date('Y-m-d H:i:s', mktime(0, 0, 0, 0, 0, (+date('Y'))-4));
    }

    public static function old() {
    	return date('Y-m-d H:i:s', mktime(0, 0, 0, 0, 0, (+date('Y'))-20));
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function lessons()
    {
        return $this->belongsToMany('Lesson');
    }

    public function orders()
    {
        return $this->hasMany('Order');
    }

    public function receipts()
    {
        return $this->hasMany('Receipt');
    }
}