<?php

View::share('assets', (new AssetCollection)->dev()->build());

Route::get('/test/{test}', function ($test)
{
	$sass = app_path().'/assets/style/tests/'.$test;
	shell_exec('sass --no-cache --update '.$sass.'.sass:'.$sass.'.css');
	$style = file_get_contents($sass.'.css');
	shell_exec('rm '.$sass.'.css');

	return View::make('layouts.test')->with('style', $style)->nest('content', 'tests.'.$test);
});

Route::get('/', function ()
{

	$data = [
		'user_name' => null,
		'fields' => [
			[
				'name' => 'email',
				'type' => 'text',
				'label' => 'Email',
			],
			[
				'name' => 'password',
				'type' => 'password',
				'label' => 'Password',
			],
		]
	];

	if (Auth::check())
		$data['user_name'] = Auth::user()->first_name.' '.Auth::user()->last_name;

	return View::make('home', $data);
});

Route::post('/log/in', function () {
    $user = [
        'email'     => Input::get('email'),
        'password'  => Input::get('password'),
    ];

    if (Auth::attempt($user)) {
    /*
        $ip = $_SERVER['REMOTE_ADDR'];

        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $geo_info = file_get_contents('http://ipinfo.io/'.$ip);
            $location = $geo_info['hostname'];

            Auth::user()->last_logged_in_from = $ip;
            Auth::user()->last_logged_in_at = $location;
            Auth::user()->save();
        }
    */
        return Redirect::intended('/');
    } else {
        return Redirect::to('/')->with('auth_failed', true);
    }
});

Route::get('/log/out', function () {
    Auth::logout();

    return Redirect::to('/');
});

Route::get('/register/child', function ()
{
	$data = [
		'verify'	=> '/verify/child',
		'user_name' => 'John Smith',
		'completed' => ['Your Information', 'Your Children'],
		'fields' => [
			[
				'name' => 'first_name',
				'type' => 'text',
				'label' => 'First Name',
			],
			[
				'name' => 'last_name',
				'type' => 'text',
				'label' => 'Last Name',
			],
			[
				'name' => 'school',
				'type' => 'text',
				'label' => 'School',
			],
			[
				'name' => 'birthday',
				'type' => 'text',
				'label' => 'Birthday',
			],
			[
				'name' => 'gender',
				'type' => 'text',
				'label' => 'Gender',
			],
			[
				'name' => 'grade',
				'type' => 'text',
				'label' => 'Grade',
			],
			[
				'name' => 'returning_player',
				'type' => 'text',
				'label' => 'Returning Player',
			],
		]
	];

	return View::make('register', $data);
});

Route::get('/register/user', function ()
{
	$data = [
		'verify'	=> '/verify/user',
		'user_name' => 'John Smith',
		'completed' => ['Your Information'],
		'fields' => [
			[
				'name' => 'first_name',
				'type' => 'text',
				'label' => 'First Name',
			],
			[
				'name' => 'last_name',
				'type' => 'text',
				'label' => 'Last Name',
			],
			[
				'name' => 'phone',
				'type' => 'text',
				'label' => 'Phone',
			],
			[
				'name' => 'email',
				'type' => 'text',
				'label' => 'Email',
			],
			[
				'name' => 'password',
				'type' => 'password',
				'label' => 'Password',
			],
			[
				'name' => 'password_confirm',
				'type' => 'password',
				'label' => 'Confirm Password',
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
		]
	];

	return View::make('register', $data);
});

Route::post('/verify/user', function ()
{
    $data = [
        'first_name'        => Input::get('first_name'),
        'last_name'         => Input::get('last_name'),
        'email'             => Input::get('email'),
        'phone'             => Input::get('phone'),
        'password'          => Input::get('password'),
        'password_confirm'  => Input::get('password_confirm'),
        'address'           => Input::get('address'),
        'city'              => Input::get('city'),
        'state'             => Input::get('state'),
        'zip_code'          => Input::get('zip_code'),
        'status'            => 2,
        'remember'          => 0,
    ];
    
    $validator = Validator::make($data, User::$rules);

    if ($validator->passes()) {
        $user = new User;

        $user->first_name   = $data['first_name'];
        $user->last_name    = $data['last_name'];
        $user->email        = $data['email'];
        $user->phone        = $data['phone'];
        $user->password     = Hash::make($data['password']);
        $user->address      = $data['address'];
        $user->city         = $data['city'];
        $user->state        = $data['state'];
        $user->zip_code     = $data['zip_code'];
        $user->status       = $data['status'];
        $user->remember     = $data['remember'];

        $user->save(); 

        $verification = new Verification;

        $verification->hash = md5(mt_rand(0, 65535));
        $verification->verified_on = null;

        $verification->save();

        $user->verification()->save($verification);

		$data = [
			'user_name' => 'John Smith',
			'another_email' => '/'
		];

        return View::make('/verify', $data);      
    }

    return Redirect::to('/register/user')->withErrors($validator)->withInput(Input::except(['password','password_confirm']));
});

Route::post('/verify/child', function () {
    $name       = explode(' ', Input::get('name'), 2);
    $first_name = $name[0];
    $last_name  = (isset($name[1])) ? $name[1] : '';

    $data = [
        'first_name'        => $first_name,
        'last_name'         => $last_name,
        'school'            => Input::get('school'),
        'birthday'          => Child::getBirthday(Input::get('birthday')),
        'age'               => Child::getAge(Input::get('birthday')),
        'grade'             => Input::get('grade'),
        'gender'            => Input::get('gender'),
        'returning_player'  => (Input::has('returning_player')) ? 1 : 0,
    ];
    
    $validator = Validator::make($data, Child::$rules);

    if ($validator->passes()) {
        $child = new Child;

        $child->first_name          = $data['first_name'];
        $child->last_name           = $data['last_name'];
        $child->school              = $data['school'];
        $child->birthday            = $data['birthday'];
        $child->age                 = $data['age'];
        $child->grade               = $data['grade'];
        $child->gender              = $data['gender'];
        $child->returning_player    = $data['returning_player'];

        $child->save(); 

        $user = Auth::user();

        $user->children()->save($child);

        $url = [
            'home'          => URL::to('/'),
            'register'      => URL::to('/register/child'),
            'sign_up'       => URL::to('/signup'),
        ]; 
        $data = [
            'title' => 'Adding your child -- myafterschoolprograms.com',
            'url'   => $url,
            'child' => $child,
        ];

        return View::make('verify_child', $data);      
    }

    return Redirect::to('/register/child')->withErrors($validator)->withInput(Input::all());
});

Route::get('/activate/{hash}', function ($hash)
{
    $verification = Verification::where('hash', '=', $hash)->first();

    Auth::loginUsingId($verification->user_id);

    $user = Auth::user();

    if ($user->status === 2) {
        $user->status = 1;
        $user->save();
    } else {
        App::abort('404');
    }

    if (is_null($verification)) App::abort('404');

	$data = [
		'user_name' => 'John Smith',
		'home' => '/register/child'
	];

    return View::make('/activate', $data);
});

Route::get('/add_to_order', ['as' => 'add to order', function () {
	$order = new Order;
	$order->user_id = intval(Auth::user()->id);
	$order->child_id = 0;
	$order->lesson_id = intval(Input::get('lesson_id'));

	$order->save();

	return Redirect::to('/enroll');
}]);

Route::get('/remove_from_order', ['as' => 'remove order', function () {
	$order = Order::destroy(+Input::get('id'));
	return Redirect::to('/enroll');
}]);

Route::get('/enroll', function ()
{
	$requested['loc'] = Input::get('locations');
	$requested['act'] = Input::get('activities');
	$requested['chi'] = Input::get('children');
    
    foreach ($requested as $key => $request) {
	    $vloc = Validator::make(
	    	[ $key => $request],
	    	[ $key => 'integer']
	    );

	    if ($vloc->fails()) {
	    	$requested[$key] = null;
	    }
	}

	$locations = Location::all();
	$names = [];

	$activities = Activity::all();
	$activity_names = [];

	if (is_null($requested['loc'])){
		if (is_null($requested['act'])) {
			$lessons = Lesson::with('dates', 'restrictions')->paginate(5);
		} else {
			$lessons = Lesson::with('dates', 'restrictions')->whereRaw('activity_id = ?', [$requested['act']])->paginate(5);
		}
	} else {
		if (is_null($requested['act'])) {
			$lessons = Lesson::with('dates', 'restrictions')->whereRaw('location_id = ?', [$requested['loc']])->paginate(5);
		} else {
			$lessons = Lesson::with('dates', 'restrictions')->whereRaw('location_id = ? && activity_id = ?', [$requested['loc'], $requested['act']])->paginate(5);
		}
	}
	$classes = [];

	$names['null'] = 'Any';
	$activity_names['null'] = 'Any';

	foreach ($locations as $location) {
		$names[$location->id] = $location->name;
	}

	foreach ($activities as $activity) {
		$activity_names[$activity->id] = $activity->name;
	}

	foreach ($lessons as $lesson) {
		$number = $lesson->number();
		$name = $lesson->starts().' '.$lesson->day();
		$price = round($lesson->price / $number, 0);

		$classes[] = [
				'id' => $lesson->id,
				'name' => $name,
				'price' => $price,
				'details' => [
					'Number of Lessons' => $number,
					'Activity' => $activity_names[$lesson->activity_id],
					'Location' => $names[$lesson->location_id],
					'Begins' => $lesson->firstLesson()->format('M jS, Y'),
					'Ends' => $lesson->lastLesson()->format('M jS, Y'),
				],
				'link' => route('add to order', ['lesson_id' => $lesson->id]),
			];
	}

	$order_models = Auth::user()->orders()->get();
	$orders = [];
	$total_price = 0;

	foreach($order_models as $order) {
		$lesson = Lesson::find($order->lesson_id);
		if (is_null($lesson)) continue;
		$name = $lesson->starts().' '.$lesson->day();
		$total_price += $lesson->price;
		$orders[$order->id] = [
			'name' => $name,
			'values' => [
				'Price' => '$'.$lesson->price,
				'Number of Lessons' => $lesson->number(),
				'Activity' => $activity_names[$lesson->activity_id],
				'Location' => $names[$lesson->location_id],
				'Begins' => $lesson->firstLesson()->format('M jS, Y'),
				'Ends' => $lesson->lastLesson()->format('M jS, Y'),				
			],
			'remove_link' => route('remove order', ['id' => $order->id])
		];
	}

	$data = [
		'review' => URL::to('/review'),
		'enroll' => '/enroll',
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'filters' => [
			[
				'label' => 'Location',
				'name' => 'locations',
				'selected' => $requested['loc'],
				'options' => $names,
			],
			[
				'label' => 'Activity',
				'name' => 'activities',
				'selected' => $requested['act'],
				'options' => $activity_names,
			]
		],
		'total_price' => $total_price,
		'orders' => $orders,
		'classes' => $classes,
		'links' => $lessons->links()
	];

	return View::make('class_selection', $data);
});

Route::get('/checkout', function () {

	$order_models = Auth::user()->orders()->with('lesson.location', 'lesson.activity')->get();
	$orders = [];
	$total_price = 0;

	foreach($order_models as $order) {
		$lesson = Lesson::find($order->lesson_id);
		if (is_null($lesson)) continue;
		$name = $lesson->starts().' '.$lesson->day();
		$total_price += $lesson->price;
		$orders[$order->id] = [
			'name' => $name,
			'values' => [
				'Price' => '$'.$lesson->price,
				'Activity' => $lesson->activity->name,
				'Location' => $lesson->location->name,
				'For' => $order->child,
			],
			'remove_link' => route('remove order', ['id' => $order->id])
		];
	}

	$data = [
		'total_price' => $total_price,
		'orders' => $orders,
		'verify' => '/verify/pay',
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'billing_fields' => [
			[
				'name' => 'first_name',
				'type' => 'text',
				'label' => 'First Name',
			],
			[
				'name' => 'last_name',
				'type' => 'text',
				'label' => 'Last Name',
			],
			[
				'name' => 'phone',
				'type' => 'text',
				'label' => 'Phone',
			],
			[
				'name' => 'email',
				'type' => 'text',
				'label' => 'Email',
			],
			[
				'name' => 'password',
				'type' => 'password',
				'label' => 'Password',
			],
			[
				'name' => 'password_confirm',
				'type' => 'password',
				'label' => 'Confirm Password',
			],
			[
				'name' => 'address',
				'type' => 'text',
				'label' => 'Address',
			],
			[
				'name' => 'address_2',
				'type' => 'text',
				'label' => 'Address (line 2)',
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
		],
		'payment_fields' => [
			[
				'name' => 'cardholder',
				'type' => 'text',
				'label' => 'Cardholder\'s name',
			],
			[
				'name' => 'expiration',
				'type' => 'date',
				'label' => 'Expiration Date',
			],
			[
				'name' => 'coupon',
				'type' => 'text',
				'label' => 'Coupon Code',
			],
		],
	];

	return View::make('pay', $data);
});

Route::get('/review', function () {
	$orders = Auth::user()->orders()->with('lesson.location', 'lesson.activity')->paginate(5);
	$classes = [];
	$total_price = 0;

	foreach($orders as $order) {
		$lesson = Lesson::find($order->lesson_id);
		if (is_null($lesson)) continue;
		$name = $lesson->starts().' '.$lesson->day();
		$total_price += $lesson->price;

		$classes[$order->id] = [
			'name' => $name,
			'details' => [
				'Price' => '$'.$lesson->price,
				'Number of Lessons' => $lesson->number(),
				'Activity' => $lesson->activity->name,
				'Location' => $lesson->location->name,
				'Begins' => $lesson->firstLesson()->format('M jS, Y'),
				'Ends' => $lesson->lastLesson()->format('M jS, Y'),				
			],
			'remove_link' => route('remove order', ['id' => $order->id]),
			'children' => [
				'label' => 'Child',
				'name' => '',
				'options' => [
					'-- Select a Child --',
					'Jane',
					'John',
				]
			],
			'selected' => ''
		];
	}

	$data = [
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'classes' => $classes,
		'links' => $orders->links(),
		'total_price' => $total_price,
		'enroll' => URL::to('/enroll'),
		'pay' => URL::to('/checkout'),
	];

	return View::make('review', $data);
});
