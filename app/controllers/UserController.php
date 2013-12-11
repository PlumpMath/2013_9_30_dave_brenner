<?php

class UserController extends ResourceController
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
                $__output[] = [
                    'name'  => $resource['email'],
                    'id'    => $resource['id'],
                    'info'  => $resource['first_name'].' '.$resource['last_name'],
                ];
            }
        } else {
            //bin holds one location
            foreach ($this->bin['resource'] as $key => $value) {
                switch ($key) {
                    case 'phone':
                        $value = '('.substr($value, 0, 3).') '.substr($value, 3, 3).'-'.substr($value, 6, 4);
                        break;
                    case 'notes':
                        $value = (is_null($value)) ? 'No Notes' : $value;
                        break;
                }

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
        return $resource['email'];
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
        return $resource['first_name'].' '.$resource['last_name'];
    }

    // }}}

    public function index()
    {
        if (Input::has('child')) {
            $child = Input::get('child');
            $users = Child::find($child)->user()->get();
            $users = $users->toArray();
        } else if (Input::has('lesson')) {
            $child = Input::get('lesson');
            $users = Lesson::find($child)->users();
        } else if (Input::has('location')) {
            $child = Input::get('location');
            $users = Location::find($child)->users();
        } else {
            $users = User::all();
            $users = $users->toArray();
        }

        $ModelName = $this->Resource;

        $data = array_merge($this->data, [
            'resources'  => ($this->format($users)->forDisplay()),
            'date' => 'none',
        ]);

        return View::make('resource.index', $data);
    }

    public function update($id)
    {
        $ModelName = $this->Resource;
        $resource_to_update = $ModelName::find($id);
        $inputs = Input::except('_method', '_token');

        $rules = $this->validation_rules;
        $rules['email'] = 'required';
        unset($rules['password']);

        $validator = Validator::make($inputs, $rules);

        if ($validator->passes()) {
            foreach($this->format($inputs)->forSaving() as $name => $value) {
                $resource_to_update->$name = $value;
            }

            $resource_to_update->save();

            return Redirect::action($this->ResourceController.'@show', $id);
        } else {
            echo "Did not pass validation. One or more of your inputs has incorrect values.\n";
            dd($validator->errors());
        }
    }
}
