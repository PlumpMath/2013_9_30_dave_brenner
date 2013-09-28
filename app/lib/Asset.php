<?php

class Asset
{
	public $src;

	public function __construct($src)
	{
		$this->src = $src;
	}
	
	public function isRemote()
	{
		return (preg_match('/(http(s)?:)?\/\//', $this->src));
	}

	public function version()
	{
		$src = public_path().'/'.$this->src;

		return asset($this->src.'?v='.base_convert(filemtime($src), 10, 32));
	}

	public function type()
	{
		if (preg_match('/css/', $this->src)) return 'css';
		return pathinfo($this->src, PATHINFO_EXTENSION);
	}
}
