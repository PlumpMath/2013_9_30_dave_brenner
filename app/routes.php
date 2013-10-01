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

Route::get('/register', function ()
{
	$data = [
		'user_name' => 'John Smith',
		'completed' => ['Your Information'],
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

	return View::make('register', $data);
});

Route::get('/enroll', function ()
{
	$locations = Location::all();
	$names = [];

	$activities = Activity::all();
	$activity_names = [];

	$lessons = Lesson::with('dates', 'restrictions')->get();
	$classes = [];

	foreach ($locations as $location) {
		$names[] = $location->name;
	}

	foreach ($activities as $activity) {
		$activity_names[] = $activity->name;
	}

	foreach ($lessons as $lesson) {
		$number = $lesson->number();
		$name = $lesson->starts().' '.$lesson->day();
		$price = round($lesson->price / $number, 0);

		$classes[] = [
				'name' => $name,
				'price' => $price,
				'details' => [
					'Number of Lessons' => $number,
					'Activity' => $activity_names[$lesson->activity_id-1],
					'Location' => $names[$lesson->location_id-1],
					'Begins' => $lesson->firstLesson()->format('M jS, Y'),
					'Ends' => $lesson->lastLesson()->format('M jS, Y'),
				]
			];
	}

	$data = [
		'user_name' => 'John Smith',
		'filters' => [
			[
				'label' => 'Location',
				'name' => 'locations',
				'options' => $names,
			],
			[
				'label' => 'Activity',
				'name' => 'activities',
				'options' => $activity_names,
			]
		],
		'total_price' => 0,
		'orders' => [],
		'classes' => $classes,
	];

	return View::make('class_selection', $data);
});
