<?php

View::share('assets', (new AssetCollection)->dev()->build());

Route::get('/test/{test}', function ($test)
{
	return App::abort(401, 'You are not authorized.');	

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

Route::get('/legal/terms_of_agreement', function ()
{
	$data = [
		'user_name' => (Auth::check()) ? Auth::user()->first_name.' '.Auth::user()->last_name : null,
	];

	return View::make('terms',$data);
});

Route::get('/legal/privacy_policy', function ()
{
	$data = [
		'user_name' => (Auth::check()) ? Auth::user()->first_name.' '.Auth::user()->last_name : null,
	];

	return View::make('privacy',$data);
});

Route::get('/register/child', function ()
{
	$data = [
		'verify'	=> '/verify/child',
		'old'		=> (Session::has('_old_input')) ? Session::get('_old_input') : [],
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
		],
		'check' => [
			'name' => 'returning_player',
			'label' => 'My child has participated in one of your classes previously',
		],
	];

	if (Auth::check())
		$data['user_name'] = Auth::user()->first_name.' '.Auth::user()->last_name;
	else
		return App::abort(401, 'You are not authorized.');		

	return View::make('register_child', $data);
});

Route::get('/register/user', function ()
{
	$data = [
		'verify'	=> '/verify/user',
		'old'		=> (Session::has('_old_input')) ? Session::get('_old_input') : [],
		'user_name' => null,
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

	if (Auth::check())
		$data['user_name'] = Auth::user()->first_name.' '.Auth::user()->last_name;

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
			'user_name' => null,
			'another_email' => URL::to('/email/verify'),
		];

		$mail_data = [
			'link' => url('/activate', ['hash' => $verification->hash])
		];

		$mail = new Email;
		$mail->user_email = $user->email;
		$mail->user_name = $user->first_name.' '.$user->last_name;
		$mail->template = 'email.verify';
		$mail->subject = 'Email Verification';
		$mail->data = serialize($mail_data);
		$mail->status = 0;

		$mail->save();

		return View::make('/verify', $data);      
	}

	return Redirect::to('/register/user')->withInput(Input::except(['password','password_confirm']))->withErrors($validator);
});

Route::get('/email/verify', function ()
{
	$data = [];

	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');

	$user = Auth::user();

	$mail_data = [];

	$mail = new Email;
	$mail->user_email = $user->email;
	$mail->user_name = $user->first_name.' '.$user->last_name;
	$mail->template = 'email.verify';
	$mail->subject = 'Email Verification';
	$mail->data = serialize($mail_data);
	$mail->status = 0;

	$mail->save();

	Redirect::to('/verfiy/user');
});

Route::post('/verify/child', function () {
	$data = [
		'first_name'        => Input::get('first_name'),
		'last_name'         => Input::get('last_name'),
		'school'            => Input::get('school'),
		'birthday'          => Child::getBirthday(Input::get('birthday')),
		'age'               => Child::getAge(Input::get('birthday')),
		'grade'             => Input::get('grade'),
		'gender'            => Input::get('gender'),
		'returning_player'  => (Input::has('returning_player')) ? 1 : 0,
	];
	
	$validator = Validator::make($data, Child::$rules);

	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');	

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

		$data = [
			'child' => $child,
			'enroll'       => URL::to('/enroll'),
			'register_child'       => URL::to('/register/child'),
		];

		$data['user_name'] = Auth::user()->first_name.' '.Auth::user()->last_name;

		return View::make('verify_child', $data);      
	}

	return Redirect::to('/register/child')->withInput(Input::all())->withErrors($validator);
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
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'home' => '/register/child'
	];

	return View::make('/activate', $data);
});

Route::get('/add_to_order', ['as' => 'add to order', function () {
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');	

	$order = new Order;
	$order->user_id = intval(Auth::user()->id);
	$order->child_id = 0;
	$order->lesson_id = intval(Input::get('lesson_id'));

	$order->save();

	return Redirect::to('/enroll');
}]);

Route::get('/add_to_wait', ['as' => 'add to wait list', function () {
	return Redirect::to('/enroll');
}]);

Route::get('/remove_from_order', ['as' => 'remove order', function () {
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');	

	$order = Order::destroy(+Input::get('id'));
	return Redirect::to('/enroll');
}]);

Route::get('/enroll', function ()
{
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');

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
		$restrict_models = $lesson->restrictions()->get();
		$grades = '';
		$gender = '';

		foreach ($restrict_models as $restriction) {
			if ($restriction->property === 'grade') {
				$grades .= $restriction->value.', ';
			} else if ($restriction->property === 'gender') {
				$gender = ucfirst($restriction->value);
			}
		}
		$spots = max($lesson->spots-count($lesson->children), 0);
		$grades = trim($grades, ', ');

		if ($spots > 0) {
			$actionable = 'Add to Order';
			$link = route('add to order', ['lesson_id' => $lesson->id]);
		} else {
			$actionable = 'Join Wait List';
			$link = route('add to wait list', ['lesson_id' => $lesson->id]);
		}

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
					'Spots' => $spots.' available',
					'Grades' => $grades,
					'Gender' => $gender
				],
				'link' => $link,
				'actionable' => $actionable,
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
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');	

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
				'For' => $order->child->first_name.' '.$order->child->last_name,
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
				'name' => 'first_name',
				'type' => 'text',
				'label' => 'Cardholder\'s First Name',
			],
			[
				'name' => 'last_name',
				'type' => 'text',
				'label' => 'Cardholder\'s Last Name',
			],
			[
				'name' => 'card_type',
				'type' => 'text',
				'label' => 'Card Type (Mastercard, Visa, etc.)',
			],
			[
				'name' => 'card_number',
				'type' => 'number',
				'label' => 'Card Number',
			],
			[
				'name' => 'expire_month',
				'type' => 'number',
				'label' => 'Expiration Month',
			],
			[
				'name' => 'expire_year',
				'type' => 'number',
				'label' => 'Expiration year',
			],
			[
				'name' => 'card_type',
				'type' => 'text',
				'label' => 'Card Type',
			],
			[
				'name' => 'card_number',
				'type' => 'number',
				'label' => 'Card Number',
			],
			[
				'name' => 'cvv',
				'type' => 'number',
				'label' => 'CVV',
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
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');

	$orders = Auth::user()->orders()->with('lesson.location', 'lesson.activity')->paginate(5);
	$classes = [];
	$total_price = 0;
	$children = Auth::user()->children()->get();

	$options = ['null' => '-- Select a Child --'];
	foreach ($children as $child) {
		$options[$child->id] = $child->first_name.' '.$child->last_name;
	}

	foreach($orders as $order) {
		$lesson = Lesson::find($order->lesson_id);
		$lesson->load('dates');

		$dates = $lesson->dates()->get();
		$templates = LessonDateTemplate::all();

		if (is_null($lesson)) continue;

		$name = $lesson->starts().' '.$lesson->day();
		$total_price += $lesson->price;

		$month = isset($_GET['m'.$order->id]) ? $_GET['m'.$order->id] : $lesson->firstLesson()->format('m');
		$year  = isset($_GET['y'.$order->id]) ? $_GET['y'.$order->id] : $lesson->firstLesson()->format('y');

		$calendar = Calendar::factory($month, $year, [

			'id' => $order->id,

		]);

		$calendar->standard('today')->standard('prev-next');

		foreach ($dates as $date) {
			$class = strtolower(preg_replace('/[-\s]/', '_', $templates[$date->lesson_date_template_id-1]->name));

			$event = $calendar->event()
				->condition('timestamp', strtotime($date->starts_on))
				->title($templates[$date->lesson_date_template_id-1]->name)
				->output($templates[$date->lesson_date_template_id-1]->description)
				->add_class($class);

			$calendar->attach($event);
		}

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
				'name' => 'child_'.$order->id,
				'options' => $options,
			],
			'selected' => (Session::has('_old_input')) ? Session::get('_old_input')['child_'.$order->id] : null,
			'calendar' => $calendar,
		];
	}
	$data = [
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'classes' => $classes,
		'links' => $orders->links(),
		'total_price' => $total_price,
		'enroll' => URL::to('/enroll'),
		'pay' => URL::to('/verify/review'),
		'terms_of_service' => URL::to('/legal/terms_of_agreement'),
		'old'		=> (Session::has('_old_input')) ? Session::get('_old_input') : [],
	];

	return View::make('review', $data);
});

Validator::extend('belongs_to_user', function($attribute, $value, $parameters)
{
	$child = Child::find($value);
	if ($child === null) return false;

	$user = $child->user()->first();
	if ($user === null) return false;

    return ($child->user->id === Auth::user()->id);
});

Validator::extend('is_eligible', function($attribute, $value, $parameters)
{
	$child = Child::find($value);
	if ($child === null) return false;

	$lesson = Order::find(substr($attribute,6))->lesson;
	if ($lesson === null) return false;

	$restrictions = $lesson->restrictions()->get();
	
	foreach ($restrictions as $restriction) {
		$prop = $restriction->property;
		$value = $restriction->value;

		if ($child->$prop === $value)
			return true;
	}

    return false;
});

Route::post('/verify/review', function () {
	$data = [
		'terms_of_agreement' => Input::get('terms_of_agreement'),
	];

	$rules = [
		'terms_of_agreement' => 'required|accepted'
	];

	$inputs = Input::all();

	foreach ($inputs as $key => $input) {
		if (preg_match('/^child_/', substr($key, 0, 6))) {
			$data[$key] = $input;
			$rules[$key] = 'required|not_in:null|integer|belongs_to_user|is_eligible';
		}
	}
	
	$validator = Validator::make($data, $rules);

	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');	

	if ($validator->passes()) {
		//class lock would go here

		foreach ($inputs as $key => $input) {
			if (preg_match('/^child_/', substr($key, 0, 6))) {
				$order = Order::find(substr($key, 6));
				$child = Child::find($input);

				$child->orders()->save($order);
			}
		}

		return Redirect::to('/checkout');      
	}

	return Redirect::to('/review')->withInput(Input::all())->withErrors($validator);
});

Route::get('/confirmation', function () {
	//attach children to lessons in orders
	$orders = Auth::user()->orders()->get();

	foreach ($orders as $order) {
		$lesson = $orders->lesson;
		$child 	= $orders->child;

		$lesson->children()->attach($child);

		//create "receipt" & attach orders to it

		//remove "checked out" spots
		$order->delete();
	}

	$data = [];

	return View::make('confirmation', $data);
});

Route::get('/dashboard', function () {
	$data = [];

	return View::make('dashboard', $data);
});

Route::post('/verify/pay', 'PaypalPaymentsController@verify');
