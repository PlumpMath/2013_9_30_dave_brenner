<?php

class LateSignUpController extends ResourceController
{
    // {{{ forDisplay

    /**
     * Formats data for display
     *
     * Expects to be chained with format  
     *
     * @return  array containing data for display
     */

    public function forDisplay()
    {
        $__output = [];

        if (isset($this->bin['resource'][0])) {
            //bin holds a list of all locations
            foreach ($this->bin['resource'] as $resource) {
            	if (isset($resource['email'])) {
            		$name = $resource['email'];
            	} else {
            		$user = User::find($resouce['user_id']);

            		$name = $user->email;
            	}

            	if (isset($resource['child_name'])) {
            		$info = $resource['child_name'];
            	} else {
            		$child = Child::find($resource['child_id']);

            		$info = $child->name;
            	}

                $__output[] = [
                    'name'  => $name,
                    'id'    => $resource['id'],
                    'info'  => $info,
                ];
            }
        } else {
            //bin holds one location
            foreach ($this->bin['resource'] as $key => $value) {

                $__output[$this->format($key)->asKey()] = $value;
            }            
        }

        return $__output;
    }

    // }}}
    // {{{ name

    /**
     * Gets a name value to use
     *
     * @return  name
     */

    public function name($resource)
    {
    	if (isset($resource['email'])) {
    		$name = $resource['email'];
    	} else {
    		$user = User::find($resouce['user_id']);

    		$name = $user->email;
    	}

    	return $name;
    }

    // }}}
    // {{{ info

    /**
     * Gets an info value
     *
     * @return  gets an info value
     */

    public function info($resource)
    {
    	if (isset($resource['child_name'])) {
    		$info = $resource['child_name'];
    	} else {
    		$child = Child::find($resource['child_id']);

    		$info = $child->name;
    	}

        return $info;
    }

    // }}}

    public function store()
    {
        $inputs = Input::all();
        $validator = Validator::make($inputs, $this->validation_rules);

        if ($validator->passes()) {

            $user = ($inputs['user_id']) ? User::find($inputs['user_id']) : null;
            $activity = Lesson::find($inputs['lesson_id'])->activity()->first()->name;
            $child = ($inputs['child_id']) ? Child::find($inputs['child_id'])->first_name : $inputs['child_name'];
            $time = (new DateTime)->modify('+1 day');

            $mail_data = [
                'user_name' => ($user) ? $user->first_name.' '.$user->last_name : $inputs['email'],
                'activity' => $activity,
                'link' => url('/register/user'),

                'subject' => 'Sign up for class',
                'summary' => 'Complete late sign up via this email.',
                'in_browser_link' => '',
                'year' => (new DateTime)->format('Y'),
                'description' => 'Hi! Thanks for expressing interest in one of our programs. To continue your late registration with myafterschoolprograms, follow the link within this email. Thank you!',

                'return_email' => 'help@myafterschoolprograms.com',
                'unsubscribe_link' => URL::to('/unsubscribe/'.urlencode( ($user) ? $user->email : $inputs['email'] )),
                'profile_preferences_link' => URL::to('/preferences/subscription'),
            ];

            $mail = new Email;
            $mail->user_email = ($user) ? $user->email : $inputs['email'];
            $mail->user_name = ($user) ? $user->first_name.' '.$user->last_name : $inputs['email'];
            $mail->template = 'email.latesignup';
            $mail->subject = 'Complete Late Sign Up Registration';
            $mail->data = serialize($mail_data);
            $mail->status = 0;

            $mail->save();

            $ModelName = $this->Resource;
            $resource_to_create = $ModelName::create($this->format($inputs)->forSaving());
            $resource_to_create->save();
            return Redirect::action($this->ResourceController.'@show', $resource_to_create->id);
        } else {
            echo "Did not pass validation. One or more of your inputs has incorrect values.\n";
            dd($validator->errors());
        }
    }

    public function create()
    {
        $data = array_merge($this->data, [
            'fields' => [
                [
                    'name' => 'email',
                    'type' => 'text',
                    'label' => 'User Email',
                ],
                [
                    'name' => 'child_name',
                    'type' => 'text',
                    'label' => 'Child\'s Name',
                ],
                [
                    'name' => 'lesson_id',
                    'type' => 'text',
                    'label' => 'Lesson ID',
                ],
            ],
        ]);

        return View::make('create.latesignup', $data);
    }
}
