<?php

class LocationController extends ResourceController
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
                    'name'  => $resource['name'],
                    'id'    => $resource['id'],
                    'info'  => $resource['address'],
                ];
            }
        } else {
            //bin holds one location
            foreach ($this->bin['resource'] as $key => $value) {
                switch ($key) {
                    case 'phone':
                        $value = '('.substr($value, 0, 3).') '.substr($value, 3, 3).'-'.substr($value, 6, 4);
                        break;
                    case 'status':
                        $value = ($value === 1) ? 'Active' : 'Inactive';
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
        return $resource['name'];
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
        return $resource['address'];
    }

    // }}}

    public function create()
    {
        $data = array_merge($this->data, [
            'fields' => [
                [
                    'name' => 'name',
                    'type' => 'text',
                    'label' => 'Name',
                ],
                [
                    'name' => 'contact_name',
                    'type' => 'text',
                    'label' => 'Contact Name',
                ],
                [
                    'name' => 'phone',
                    'type' => 'text',
                    'label' => 'Phone',
                ],
                [
                    'name' => 'capacity',
                    'type' => 'text',
                    'label' => 'Capacity',
                ],
                [
                    'name' => 'address',
                    'type' => 'text',
                    'label' => 'Address',
                ],
                [
                    'name' => 'city',
                    'type' => 'text',
                    'label' => 'City',
                ],
                [
                    'name' => 'state',
                    'type' => 'text',
                    'label' => 'State',
                ],
                [
                    'name' => 'zip_code',
                    'type' => 'text',
                    'label' => 'Zip Code',
                ],
                [
                    'name' => 'provider',
                    'type' => 'text',
                    'label' => 'Provider',
                ],
                [
                    'name' => 'status',
                    'type' => 'text',
                    'label' => 'Status',
                ],
            ],
        ]);

        return View::make('create.location', $data);
    }

    public function show($id)
    {
        $ModelName = $this->Resource;
        $resource_to_show = $ModelName::find($id)->toArray();

        $url = array_merge($this->url, [
            'copy'   => action($this->ResourceController.'@copy', $id),
            'delete' => action($this->ResourceController.'@destroy', $id),
            'edit'   => action($this->ResourceController.'@edit', $id),
            'receipts' => action('ReceiptController@index'),
            'lessons' => action('LessonController@index'),
            'users' => action('UserController@index'),
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
}
