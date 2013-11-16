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

    public function prorate()
    {
        $price = $this->price;
        $ax = $price;
        $lessons = $this->dates()->where('lesson_date_template_id', '=', '8')->get();
        $number = count($lessons);
        $now = new DateTime;

        foreach ($lessons as $lesson) {
            $lesson_start = new DateTime($lesson->starts_on);

            if ($now > $lesson_start) {
                $ax -= $price/$number;
            }
        }

        return round($ax, 2);
    }

    public function isUser($user_id)
    {
        foreach ($this->user()->get() as $user) {
            if ($user->id == $user_id) return true;
        }

        return false;
    }

    public function nextClass()
    {
        $lessons = $this->dates()->where('lesson_date_template_id', '=', '8')->get();
        $now = new DateTime;
        $previous_lesson = null;
        $previous_lesson_start = new DateTime;

        foreach ($lessons as $lesson) {
            $lesson_start = new DateTime($lesson->starts_on);

            //if the lesson hasn't started yet
            if ($now < $lesson_start) {
                //if this lesson is before the previously capture lesson
                if ($lesson_start < $previous_lesson_start) {
                    $previous_lesson = $lesson;
                    $previous_lesson_start = $lesson_start;
                }
            }
        }

        return $previous_lesson_start;
    }

    public function spots()
    {
        $orders = count(Order::where('lesson_id', '=', $this->id)->get());

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