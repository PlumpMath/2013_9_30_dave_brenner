<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

    /* User status notes

    2 => just made, awaiting verification
    1 => verified
    0 => deactivated
    */

// {{{ User

class User extends Resource implements UserInterface, RemindableInterface {

    // {{{ properties

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    protected $relations_to = [
        'LateSignUp',
        'Verification',
        'Child',
        'Notifications',
        'Orders',
        'Receipts',
        'Waitlists',
    ];

    public static $rules = [
        'first_name'    => 'required',
        'last_name'     => 'required',
        'email'         => 'required|email|unique:users',
        'phone'         => 'required',
        'password'      => 'required|min:6|same:password_confirm',
        'address'       => 'required',
        'address_2'     => '',
        'city'          => 'required',
        'state'         => 'required',
        'zip_code'      => 'required',
    ];

    // }}}
    // {{{ getAuthIdentifier

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    // }}}
    // {{{ getAuthPassword

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    // }}}
    // {{{ getReminderEmail

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    // }}}
    // {{{ latesignups

    /**
     * Get the user's latesignups
     *
     * @return collection of latesignups
     */

    public function latesignups()
    {
        return $this->hasMany('LateSignUps');
    }

    // }}}
    // {{{ verification

    /**
     * Get the user's verification
     *
     * @return verification
     */

    public function verification()
    {
        return $this->hasOne('Verification');
    }

    // }}}
    // {{{ children

    /**
     * Get the user's children
     *
     * @return collection of children
     */

    public function children()
    {
        return $this->hasMany('Child');
    }

    // }}}

    public function lessons()
    {
        $lessons = [];
        $children = $this->children()->get();

        foreach ($children as $child) {
            $ls = $child->lessons()->get();

            foreach ($ls as $l) $lessons[] = $l;
        }

        return $lessons;
    }

    public function orders()
    {
        return $this->hasMany('Order');
    }

    public function notifications()
    {
        return $this->hasMany('Notification');
    }

    public function waitlists()
    {
        return $this->hasMany('Waitlist');
    }
}

// }}}
