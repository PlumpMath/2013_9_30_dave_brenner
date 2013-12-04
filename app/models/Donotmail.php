<?php

class Donotmail extends Resource {
    public $timestamps = false;
    
    protected $guarded = array();
    protected $table = 'donotmail';

    public static $rules = array();

    public static function thisAddress($email)
    {
        $blacklist = Donotmail::all();

        foreach ($blacklist as $address) {
            if ($address->email == $email) return true;
        }

        return false;
    }
}