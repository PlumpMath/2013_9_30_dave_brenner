<?php

class SelectGroup
{
	protected $name;
	protected $label;
	protected $options;

	protected $templates;

	public function __construct()
	{
		$this->templates = [
			'errors' => 'selectgroup.error',
			'label' => 'selectgroup.label',
			'main' => 'selectgroup.main',
		];
	}

	public function add($name, $value)
	{
		$this->options[] = [
			'name' => $name,
			'value' => $value,
		];

		return $this;
	}

	public function name($name)
	{
		$this->name = $name;

		return $this;
	}

	public function label($name)
	{
		$this->label = $name;

		return $this;
	}

	public function render()
	{
		return View::make($this->templates['error'])
			->nest('input', $this->templates['main'])
			->nest('label', $this->templates('label'));
	}
}
