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

Route::get('/PAL', function ()
{
	$data = [
		'PROGRAM' => 'Tennis',
		'YEAR' => '2013',
		'NAME' => 'Betty Botter',
		'ADDRESS' => '55 Example Road',
		'TOWN' => 'Example Town',
		'ZIP' => '55555',
		'PHONE' => '5555555555',
		'DOB' => '55/55/5555',
		'AGE' => '5',
		'NEWPLAYER' => false,
		'MALE' => true,
		'GRADE' => '5',
		'SIGNATURE' => 'Mary Botter',
		'DATE' => '55/55/5555',
	];

	return View::make('PAL', $data);
/*
	$pdf = PDF::make();
	$pdf->addPage($view->render());
	$pdf->send();

	dd($pdf->getError());
*/
});

Route::post('/log/in', function ()
{
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

		return Redirect::intended('/dashboard');
	} else {
		return Redirect::to('/')->with('auth_failed', true);
	}
});

Route::get('/email/waiting', function () {
	$student = 'BETTY BOTTER';
	$day = 'MONDAYS';
	$time = '5-6 PM';

	$data = [
		'student' => 'BETTY BOTTER',
		'location' => 'WESTHAMPTON BEACH TENNIS AND SPORT',
		'address' => '86 DEPOT RD, WESTHAMPTON BEACH, NY, 11978',
		'phone' => '555.555.5555',
		'activity' => 'TENNIS',
		'session' => 'DEC/JAN 2013',
		'day' => 'MONDAYS',
		'time' => '5-6PM',
		'class' => '3RD-4TH GRADE',
		'dates' => '11/4,  11/11,  11/18,  11/25,  12/2,  12/9, 11/16, (Not 12/23) (Not 12/30) 1/6, (Make up for class cancelation - 1/13)',
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'email' => 'steinbilly@gmail.com',
		'link' => '',

		'subject' => 'Order Confirmation',
		'summary' => 'Signed up for classes with myafterschoolprograms',
		'in_browser_link' => '',
		'year' => (new DateTime)->format('Y'),
		'description' => 'You\'ve signed '.$student.' up for classes on '.$day.' at '.$time.'.',
		'return_email' => 'someprefix@mysafterschoolprograms.com',
		'unsubscribe_link' => '',
		'profile_preferences_link' => '',
	];

	return View::make('email.waiting', $data);
});

Route::get('/email/confirm', function () {
	$child = Child::find(1);
	$lesson = Lesson::find(1);
	$location = $lesson->location;

	$student = strtoupper($child->first_name.' '.$child->last_name);
	$activity = strtoupper($lesson->activity->name);
	$day = 'MONDAYS';
	$time = '5-6PM';
	$dates = '11/4,  11/11,  11/18,  11/25,  12/2,  12/9, 11/16, (Not 12/23) (Not 12/30) 1/6, (Make up for class cancelation - 1/13)';

	$unsub = '';
	$our_email = 'someprefix@mysafterschoolprograms.com';

	//send mail
	$data = [
		'student' => $student,
		'location' => strtoupper($location->name),
		'address' => strtoupper($location->address.', '.$location->city.', '.$location->state.', '.$location->zip_code),
		'phone' => strtoupper($location->phone),
		'activity' => $activity,
		'session' => 'DEC/JAN 2013',
		'day' => $day,
		'time' => $time,
		'class' => '3RD-4TH GRADE',
		'dates' => $dates,
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'email' => 'steinbilly@gmail.com',
		'link' => '',

		'subject' => 'Order Confirmation',
		'summary' => 'We\'ve received your order, and have signed '.$student.' up for '.$activity.' lessons. Thank you!',
		'in_browser_link' => '',
		'year' => (new DateTime)->format('Y'),
		'description' => 'We\'ve received your order, and have signed '.$student.' up for '.$activity.' lessons. The lesson will be from '.$time.' on '.$day.' for these dates: '.$dates.'. If this information is incorrect, you did not place this order, email us at: '.$our_email.'. On the other hand, if this email address is incorrect and you think you\'ve received this notification in error, please click our unsubscribe link: '.$unsub.'.Thank you!',
		'return_email' => $our_email,
		'unsubscribe_link' => $unsub,
		'profile_preferences_link' => '',
	];

	return View::make('email.confirmation', $data);
});


Route::get('/email/verify/test', function () {
	$data = [
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'email' => 'steinbilly@gmail.com',
		'link' => '',

		'subject' => '',
		'summary' => '',
		'in_browser_link' => '',
		'year' => '',
		'description' => '',
		'return_email' => '',
		'unsubscribe_link' => '',
		'profile_preferences_link' => '',
	];

	return View::make('email.verify', $data);
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
				'label' => 'School District',
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
				'name' => 'address_2',
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
			'email' => 'm7@example.com',
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

	$data = [
		'user_name' => null,
		'another_email' => URL::to('/email/verify'),
		'email' => 'm5@example.com',
	];

	return View::make('/verify', $data);   
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
	if (is_null($verification)) App::abort('404');

	Auth::loginUsingId($verification->user_id);

	$user = Auth::user();

	if ($user->status == 2) {
		$user->status = 1;
		$user->save();
	} else {
		App::abort('404');
	}

	$verification->verified_on = (new DateTime)->format('Y-m-d H:i:s');
	$verification->save();

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
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');	

	$waitlist = new Waitlist;
	$waitlist->user_id = intval(Auth::user()->id);
	$waitlist->child_id = 0;
	$waitlist->lesson_id = intval(Input::get('lesson_id'));

	$waitlist->save();

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
		$opensignup = $lesson->dates()->where('lesson_date_template_id', '=', '2')->first();
		$latesignup = $lesson->dates()->where('lesson_date_template_id', '=', '3')->first();
		$courtesysignup = $lesson->dates()->where('lesson_date_template_id', '=', '1')->first();

		/** /
		if ( ! $opensignup && ! $latesignup && ( ! $courtesysignup || ! $lesson->isUser(Auth::user()->id))) continue;
		else {
			$now = new DateTime;
			$signup_starts = $opensignup->starts_on;
			$signup_ends = $opensignup->ends_on;

			if ($now < $signup_starts || $now > $signup_ends) continue;
		}
		/**/

		$order = Order::whereRaw('lesson_id = ? and user_id = ?', [$lesson->id, Auth::user()->id])->first();
		$waitlist = count(Waitlist::where('lesson_id', $lesson->id)->get());

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

		$spots = max($lesson->spots() - $waitlist, 0);
		$grades = trim($grades, ', ');
		if ($order) {
			$actionable = 'In Cart';
			$link = '';
		} else {
			if ($spots > 0) {
				$actionable = 'Add to Order';
				$link = route('add to order', ['lesson_id' => $lesson->id]);
			} else {
				$actionable = 'Join Wait List';
				$link = route('add to wait list', ['lesson_id' => $lesson->id]);
			}
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
		'enroll' => URL::to('/enroll'),
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
		'links' => $lessons->appends(['locations' => $requested['loc'], 'activities' => $requested['act']])->links()
	];

	return View::make('class_selection', $data);
});

Route::get('/checkout', function () {
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');	
	
	$order_models = Auth::user()->orders()->with('lesson.location', 'lesson.activity')->get();

	if (count($order_models) === 0) return Redirect::to('/review');

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

Validator::extend('coupon', function($attribute, $value, $parameters)
{
	$user = Auth::user();
	if ($user === null) return false;

	$coupons = $user->coupons()->get();
	if ($coupon === null) return false;

	foreach ($coupons as $coupon) {
		if ($coupon->code === $attribute) return true;
	}

    return false;
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
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');

	$user = Auth::user();

	//receipts
	$receipts = [];
	$confirmation_id = substr('O'.'-'
		.substr(md5((new DateTime)->format('Y-m-d H:i:s')), 0, 8).'-'
		.substr(md5($user->id), 0, 4).'-'
		.md5(mt_rand(0,65535)),
	0, 32);

	while (Receipt::where('confirmation_id', $confirmation_id)->first()) {
		$confirmation_id = substr('O'.'-'
			.substr(md5((new DateTime)->format('Y-m-d H:i:s')), 0, 8).'-'
			.substr(md5($user->id), 0, 4).'-'
			.md5(mt_rand(0,65535)),
		0, 32);
	}

	//get used coupons for transaction
	$coupons = [];

	foreach ($coupons as $coupon) {
		//create "receipt" & attach coupons to it
		$receipt = new Receipt;

		$receipt->confirmation_id = $confirmation_id;
		$reciept->user->associate($user);
		$receipt->lesson->associate($coupon);

		$receipt->save();

		$name = 'Coupon used!';
		$price = $coupon->price;
		$link = '';
		$actionable = '';

		$receipts[] = [
			'name' => $name,
			'price' => $price,
			'details' => [

			],
			'link' => $link,
			'actionable' => $actionable,
		];
	}

	//attach children to lessons in orders
	$orders = $user->orders()->get();

	foreach ($orders as $order) {
		$lesson = $order->lesson;
		$child 	= $order->child;
		$location = $lesson->location;

		$lesson->children()->attach($child);

		$student = strtoupper($child->first_name.' '.$child->last_name);
		$activity = strtoupper($lesson->activity->name);
		$day = 'MONDAYS';
		$time = '5-6PM';
		$dates = '11/4,  11/11,  11/18,  11/25,  12/2,  12/9, 11/16, (Not 12/23) (Not 12/30) 1/6, (Make up for class cancelation - 1/13)';

		$unsub = '';
		$our_email = 'someprefix@mysafterschoolprograms.com';

		//send mail
		$mail_data = [
			'student' => $student,
			'location' => strtoupper($location->name),
			'address' => strtoupper($location->address.', '.$location->city.', '.$location->state.', '.$location->zip_code),
			'phone' => strtoupper($location->phone),
			'activity' => $activity,
			'session' => 'DEC/JAN 2013',
			'day' => $day,
			'time' => $time,
			'class' => '3RD-4TH GRADE',
			'dates' => $dates,
			'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
			'email' => 'steinbilly@gmail.com',
			'link' => '',

			'subject' => 'Order Confirmation',
			'summary' => 'We\'ve received your order, and have signed '.$student.' up for '.$activity.' lessons. Thank you!',
			'in_browser_link' => '',
			'year' => (new DateTime)->format('Y'),
			'description' => 'We\'ve received your order, and have signed '.$student.' up for '.$activity.' lessons. The lesson will be from '.$time.' on '.$day.' for these dates: '.$dates.'. If this information is incorrect, or you did not place this order, email us at: '.$our_email.'. On the other hand, if this email address is incorrect and you think you\'ve received this notification in error, please click our unsubscribe link: '.$unsub.'.Thank you!',
			'return_email' => $our_email,
			'unsubscribe_link' => $unsub,
			'profile_preferences_link' => '',
		];

		$mail = new Email;
		$mail->user_email = $user->email;
		$mail->user_name = $user->first_name.' '.$user->last_name;
		$mail->template = 'email.confirmation';
		$mail->subject = 'Order Confirmed';
		$mail->data = serialize($mail_data);
		$mail->status = 0;

		$mail->save();

		//create "receipt" & attach orders to it
		$receipt = new Receipt;

		$receipt->confirmation_id = $confirmation_id;
		$receipt->user()->associate($user);
		$receipt->lesson()->associate($lesson);
		$receipt->child()->associate($child);

		$receipt->save();

		$name = 'Class for '.$child->first_name.' '.$child->last_name;
		$price = $lesson->price;
		$link = '';
		$actionable = '';

		$receipts[] = [
			'name' => $name,
			'price' => $price,
			'details' => [

			],
			'link' => $link,
			'actionable' => $actionable,
		];

		//remove "checked out" spots
		$order->delete();
	}

	$data = [
		'receipts' => $receipts,
		'confirmation_id' => $confirmation_id,
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'print' => ''
	];

	return View::make('confirmation', $data);
});

Route::get('/lesson/{id}', function ($id)
{
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');

	$lesson = Lesson::find($id);

	if ( ! $lesson)
		return App::abort(404);

	$dates = $lesson->dates();
	$templates = LessonDateTemplate::all();

	$month = Input::has('m') ? Input::get('m') : $lesson->firstLesson()->format('m');
	$year  = Input::has('y') ? Input::get('y') : $lesson->firstLesson()->format('y');

	$calendar = Calendar::factory($month, $year);

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

	$data = [
		'calendar' => $calendar,
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
	];

	return View::make('lesson', $data);
});

Route::get('/dashboard', function ()
{
	if ( ! Auth::check())
		return App::abort(401, 'You are not authorized.');

	$children = Auth::user()->children()->get();
	$lessons = [];
	$classes = [];

	foreach ($children as $child) {
		$child->link = '';
		$lessons = $child->lessons()->get();

		foreach ($lessons as $lesson) {
			$name = 'Class for '.$child->first_name.' '.$child->last_name;
			$location = $lesson->location;
			$price = 'Price';
			$link = '';
			$actionable = 'Yo';

			$classes[] = [
				'name' => $name,
				'price' => $price,
				'details' => [
					'Location' => $location->name,
					'Address' => $location->address.', '.$location->city,
					'Next Class' => '',
					'See Calendar' => '<a href="'.URL::to('/lesson', ['id' => $lesson->id]).'">View</a>',
				],
				'link' => $link,
				'actionable' => $actionable,
			];		
		}
	}

	$data = [
		'register_child' => URL::to('/register/child'),
		'user_name' => Auth::user()->first_name.' '.Auth::user()->last_name,
		'your_info' => '',
		'children' => $children,
		'notifications' => Auth::user()->notifications()->get(),
		'classes' => $classes,
	];

	return View::make('dashboard', $data);
});

Route::get('/account', function ()
{
	$data = [];

	$data = [
		'user_name' => null,
	];

	return View::make('reset', $data);   
});

Route::get('/account/password', function ()
{
	$data = [];

	$data = [
		'user_name' => null,
	];

	return View::make('reset_password', $data);   
});

Route::get('/account/user', function ()
{
	$data = [];

	$data = [
		'user_name' => null,
	];

	return View::make('reset_user', $data);   
});

Route::post('/verify/pay', 'PaypalPaymentsController@verify');

// ACTIVITIES

Route::post('/activities/search', 'ActivityController@search');
Route::post('/activities/affect', 'ActivityController@affect');
Route::get('/activities/{id}/copy', 'ActivityController@copy');

Route::resource('activities', 'ActivityController');

// CHILDREN

Route::post('/children/search', 'ChildController@search');
Route::post('/children/affect', 'ChildController@affect');
Route::get('/children/{id}/copy', 'ChildController@copy');

Route::resource('children', 'ChildController');

// COUPONS

Route::post('/coupons/search', 'CouponController@search');
Route::post('/coupons/affect', 'CouponController@affect');
Route::get('/coupons/{id}/copy', 'CouponController@copy');

Route::resource('coupons', 'CouponController');

// LATESIGNUPS

Route::post('/latesignups/search', 'LateSignUpController@search');
Route::post('/latesignups/affect', 'LateSignUpController@affect');
Route::get('/latesignups/{id}/copy', 'LateSignUpController@copy');

Route::resource('latesignups', 'LateSignUpController');

// LESSONS

Route::post('/lessons/search', 'LessonController@search');
Route::post('/lessons/affect', 'LessonController@affect');
Route::get('/lessons/{id}/copy', 'LessonController@copy');

Route::resource('lessons', 'LessonController');

// LOCATIONS

Route::post('/locations/search', 'LocationController@search');
Route::post('/locations/affect', 'LocationController@affect');
Route::get('/locations/{id}/copy', 'LocationController@copy');

Route::resource('locations', 'LocationController');

// RECEIPTS

Route::post('/receipts/search', 'ReceiptController@search');
Route::post('/receipts/affect', 'ReceiptController@affect');
Route::get('/receipts/{id}/copy', 'ReceiptController@copy');

Route::resource('receipts', 'ReceiptController');

// USERS

Route::post('/users/search', 'UserController@search');
Route::post('/users/affect', 'UserController@affect');
Route::get('/users/{id}/copy', 'UserController@copy');

Route::resource('users', 'UserController');

// WAITLISTS

Route::post('/waitlists/search', 'WaitlistController@search');
Route::post('/waitlists/affect', 'WaitlistController@affect');
Route::get('/waitlists/{id}/copy', 'WaitlistController@copy');

Route::resource('waitlists', 'WaitlistController');
