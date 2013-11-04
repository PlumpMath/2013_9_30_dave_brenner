<?php

class AdminPanel
{
	public function index()
	{
		//show all lessons
		$lessons = Lesson::with('dates.template', 'restrictions', 'children', 'location', 'activity');
		//indexeable by location
		//show users attending

		//allow to print out sign in sheets
	}

	public function create()
	{
		//create a lesson

		//attach a location

		//attach an activity

		//attach lesson dates

		//create lesson date templates

		//attach lesson restrictions

		//attach children

	}

	public function store()
	{
		//save & validate resource
	}

	public function show()
	{
		//show singular resource
	}

	public function edit()
	{
		//same as create
	}

	public function update()
	{
		//same as store
	}

	public function destroy()
	{
		//destory lesson
	}
}
