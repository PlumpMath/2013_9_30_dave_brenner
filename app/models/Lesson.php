<?php

class Lesson extends Resource {
    protected $guarded = [];

    public static $rules = [
    ];

    protected $relations_to = [
        'LessonDate',
        'Location',
        'Children',
        'LateSignUp',
        'Activity',
        'LessonRestriction',
        'Order',
        'Waitlist',
    ];

    public function day()
    {
        $d = new DateTime($this->dates()->first()->starts_on);

        return $d->format('l');
    }

    public function starts()
    {
        $d = new DateTime($this->dates()->first()->starts_on);

        return $d->format('g:ia');
    }

    public function number()
    {
        return count($this->dates()->where('lesson_date_template_id', '=', '8')->get());
    }

    public function firstLesson()
    {
        $dates = $this->dates()->where('lesson_date_template_id', '=', '8')->get();
        $earliest = new DateTime('3000');

        foreach ($dates as $date) {
            $date = new DateTime($date->starts_on);

            if ($date < $earliest) $earliest = $date;
        }

        return $earliest;
    }

    public function lastLesson()
    {
        $dates = $this->dates()->where('lesson_date_template_id', '=', '8')->get();
        $latest = new DateTime('1000');

        foreach ($dates as $date) {
            $date = new DateTime($date->ends_on);

            if ($date > $latest) $latest = $date;
        }

        return $latest;

    }

    public function spots()
    {
        $orders = count(Order::where('lesson_id', '=', $lesson->id)->get());

        return max($this->spots - (count($this->children) + $orders), 0);
    }

    public function firstInLine()
    {
        return $this->waiting()->first();
    }

    public function activity()
    {
        return $this->belongsTo('Activity');
    }

    public function late_sign_up()
    {
        return $this->hasMany('LateSignUp');
    }

    public function dates()
    {
        return $this->hasMany('LessonDate');
    }

    public function location()
    {
        return $this->belongsTo('Location');
    }

    public function children()
    {
        return $this->belongsToMany('Child');
    }

    public function restrictions()
    {
        return $this->belongsToMany('LessonRestriction');
    }

    public function order()
    {
        return $this->hasMany('Order');
    }

    public function waiting()
    {
        return $this->hasMany('Waitlist');
    }
}