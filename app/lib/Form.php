<?php

class Form
{
	protected $inputs;
	protected $templates;

	public function add($name, $obj)
	{
		$obj->name($name);

		$inputs[$name] = $obj;

		return $this;
	}

	public function render()
	{

	}
}
