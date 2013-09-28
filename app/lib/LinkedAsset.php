<?php

class LinkedAsset extends Asset
{
	public function __construct($src)
	{
		parent::__construct($src);

		$type = $this->type();
		$this->src = ($this->isRemote()) ? $this->src : $this->version();

		switch ($type) {
			case 'css':
				$this->src = HTML::style($this->src);
				break;
			case 'js':
				$this->src = HTML::script($this->src);
				break;
		}
	}
}
