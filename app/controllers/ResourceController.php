<?php
// {{{ ResourceController

/**
 * Base class to be extending by controllers
 * looking to implement restful methods and that
 * represent a "resource"
 */

class ResourceController extends BaseController
{
    // {{{ properties

    protected $bin;

    // }}}
    // {{{ Constructor

    public function __construct()
    {
        //Filters
        $this->beforeFilter('auth');

        $this->beforeFilter('csrf', array('on' => 'post'));

        //Names for resource

        //to separate FooBar into Foo Bar
        $regex = '/(?<!^)((?<![[:upper:]])[[:upper:]]|[[:upper:]](?![[:upper:]]))/';

        $this->ResourceController = get_class($this);
        $this->Resource = explode('Controller', $this->ResourceController, 2)[0];
        $this->Resources = preg_replace( $regex, ' $1', str_plural($this->Resource));
        $this->resource = strtolower($this->Resource);
        $this->resources = strtolower($this->Resources);

        $ModelName = $this->Resource;

        $this->validation_rules = $ModelName::$rules;

        //fields that are needed for create $filleable

        //urls to be made available to Views
        $this->url = [
            'log_out'   => URL::to('/log/out'),
            'home'      => URL::to('/'),
            'index'     => action($this->ResourceController.'@index'),
            'create'    => action($this->ResourceController.'@create'),
            'store'     => action($this->ResourceController.'@store'),
        ];

        //default data to send to each View
        $this->data = [
            'title'         => 'myafterschoolprograms.com',
            'url'           => $this->url,
            'user_name'     => Auth::user()->first_name.' '.Auth::user()->last_name,
            'Resources'     => $this->Resources,
            'Resource'     => $this->Resource,
        ];
    }

    // }}}
    // {{{ format

    /**
     * Saves data to be used with forDisplay or forSaving
     *
     * Expects to be chained with forDisplay or forSaving
     *
     * @param   $data    data to pass to forDisplay or forSaving
     *
     * @return  $this
     */

    public function format($data)
    {
        if (is_array($data)) {
            $this->bin['resource'] = $data;
        } else {
            $this->bin['key'] = $data;
        }

        return $this;
    }

    // }}}
    // {{{ asKey

    /**
     * Converts key from foo_bar to Foo Bar
     *
     * Expects to be chained with format
     *
     * @return  key with correct formatting
     */

    public function asKey()
    {
        $str = $this->bin['key'];
        $pieces = explode('_', $str);
        
        foreach($pieces as $key => $piece) {
            $pieces[$key] = ucfirst($piece);
        }
        
        return implode(' ', $pieces);
    }

    // }}}
    // {{{ forDisplay

    /**
     * Formats data for display
     *
     * Expects to be chained with format ie $this->format($to_display)->forDisplay()  
     *
     * @return  array containing data for display
     */

    public function forDisplay()
    {
        return $this->bin['resource'];
    }

    // }}}
    // {{{ forSaving

    /**
     * Formats data for saving
     *
     * Expects to be chained with format ie $this->format($to_save)->forSaving() 
     *
     * @return  array containing data for saving
     */

    public function forSaving()
    {
        return $this->bin['resource'];
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
        return $this->bin['name'];
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
        return $this->bin['info'];
    }

    // }}}
    // {{{ search

    /**
     * Searches a resource
     *
     * @return  returns resources that match
     */

    public function search()
    {
        if ( ! Input::has('request')) return;

        $ModelName = $this->Resource;

        foreach($ModelName::all()->toArray() as $Model) {
            foreach($Model as $prop => $value) {

            }
        }

        return $this->bin['info'];
    }

    // }}}
    // {{{ index

    /**
     * ResourceController@index  
     *
     * A view containing an index of all resources
     * Available at url: /resource
     *
     * @return  View    resource.index
     */

    public function index()
    {
        $ModelName = $this->Resource;

        $data = array_merge($this->data, [
            'resources'  => ($this->format($ModelName::all()->toArray())->forDisplay()),
            'date' => 'none',
        ]);

        return View::make('resource.index', $data);
    }

    // }}}
    // {{{ show

    /**
     * ResourceController@show  
     *
     * A view showing a specific resource
     * Available at url: /resource/$id
     *
     * @param   $id     id of the resource to show
     *
     * @return  View    resource.show
     */

    public function show($id)
    {
        $ModelName = $this->Resource;
        $resource_to_show = $ModelName::find($id)->toArray();

        $url = array_merge($this->url, [
            'copy'   => action($this->ResourceController.'@copy', $id),
            'delete' => action($this->ResourceController.'@destroy', $id),
            'edit'   => action($this->ResourceController.'@edit', $id),
            'receipts' => action('ReceiptController@index'),
        ]);

        $data = array_merge($this->data, [
            'name'          => $this->name($resource_to_show),
            'info'          => $this->info($resource_to_show),
            'resource'      => $this->format($resource_to_show)->forDisplay(),
            'resource_id'   => $id,
            'input_name'    => $this->resource,
            'url'           => $url,
        ]);
        
        return View::make('resource.show', $data);
        
    }

    // }}}
    // {{{ create

    /**
     * ResourceController@create  
     *
     * A view for creating a new resource
     * Available at url: /resource/create
     *
     * @return  View    resource.create
     */

    public function create()
    {
        return View::make('resource.create', $this->data);       
    }

    // }}}
    // {{{ store

    /**
     * ResourceController@store  
     *
     * A view for storing a new resource
     * Available at url: /resource, with method PUT
     *
     * @return  ResourceController@show
     */

    public function store()
    {
        $inputs = Input::all();
        $validator = Validator::make($inputs, $this->validation_rules);

        if ($validator->passes()) {
            $ModelName = $this->Resource;
            $resource_to_create = $ModelName::create($this->format($inputs)->forSaving());
            $resource_to_create->save();
            return Redirect::action($this->ResourceController.'@show', $resource_to_create->id);
        } else {
            echo "Did not pass validation. One or more of your inputs has incorrect values.\n";
            dd($validator->errors());
        }
    }

    // }}}
    // {{{ edit

    /**
     * ResourceController@edit  
     *
     * A view showing a form to update a specific resource
     * Available at url: /resource/$id/edit
     *
     * @param   $id     id of the resource to edit
     *
     * @return  View    resource.edit
     */

    public function edit($id)
    {
        $ModelName = $this->Resource;
        $resource_to_edit = $ModelName::find($id)->toArray();
        
        $data = array_merge($this->data, [
            'resource' => $this->format($resource_to_edit)->forDisplay(),
        ]);
        
        return View::make('resource.edit', $data);        
    }

    // }}}
    // {{{ update

    /**
     * ResourceController@update
     *
     * Updates a specific resource
     * Available at url: /resource/$id, with method PUT
     *
     * @param   $id     id of the resource to update
     *
     * @return  ResourceController@show
     */

    public function update($id)
    {
        $ModelName = $this->Resource;
        $resource_to_update = $ModelName::find($id);
        $inputs = Input::all();
        $validator = Validator::make($inputs, $this->validation_rules);

        if ($validator->passes()) {
            $resource_to_update->update($this->format($inputs)->forSaving());

            return Redirect::action($this->ResourceController.'@show', $id);
        } else {
            echo "Did not pass validation. One or more of your inputs has incorrect values.\n";
            dd($validator->errors());
        }
    }

    // }}}
    // {{{ destroy

    /**
     * ResourceController@destroy  
     *
     * Deletes a specific resource
     * Available at url: /resource/$id, with method DELETE
     *
     * @param   $id     id of the resource to delete
     *
     * @return  ResourceController@index
     */

    public function destroy($id)
    {
        $ModelName = $this->Resource;
        $ModelName::destroy($id);
        
        return Redirect::action($this->ResourceController.'@index');
    }
    
    public function copy($id)
    {
        $ModelName = $this->Resource;
        $resource_to_copy = $ModelName::find($id);
        $array_from_resource = $resource_to_copy->toArray();
        unset($array_from_resource['id']);
        $resource_copied = $ModelName::create($array_from_resource);

        return Redirect::action($this->ResourceController.'@show', $resource_copied->id);
    }

    // }}}

    /////////////////////////////////////////////////////////////////////////////////////
    /*
    public function affect()
    {
        $locations = json_decode(Input::get('locations_to_affect'));
        $isCopy = (Input::get('copy_submit', false) === '') ? true : false;
        $isEdit = (Input::get('edit_submit', false) === '') ? true : false;
        $isDelete = (Input::get('delete_submit', false) === '') ? true : false;

        foreach($locations as $id) {
            if ($isCopy) {
                $resource_to_copy = Location::find($id);
                $array_from_resource = $resource_to_copy->toArray();
                unset($array_from_resource['id']);
                $resource_copied = Location::create($array_from_resource);                
            } else if ($isEdit) {
                
            } else if ($isDelete) {
                Location::destroy($id);
            }
        }

        return Redirect::action('LocationController@index');
    }

    public function search()
    {
        if (!Input::has('request')) return;
        $request = explode(' ', strtolower(Input::get('request')));
        $results = array();
        $locations = Location::all();

        foreach($locations as $location) {
            $location = $location->toArray();
            foreach($location as $var => $value) {
                foreach($request as $word) {
                    if (strpos(strtolower($value), $word) > -1) {
                        $results[] = array('id' => $location['id'],
                                           'name' => $location['name'],
                                           'address' => $location['address'],
                                           'search_value' => $value,
                                           'search_key' => $var,
                                           'url_show' => action('LocationController@show', $location['id'])
                                           );
                    }
                }
            }
        }

        return (json_encode($results));
    }

    
    public function copy($id)
    {
        $resource_to_copy = Location::find($id);
        $array_from_resource = $resource_to_copy->toArray();
        unset($array_from_resource['id']);
        $resource_copied = Location::create($array_from_resource);

        return Redirect::action('LocationController@show', $resource_copied->id);
    }
    */
}

// }}}
