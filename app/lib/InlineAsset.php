<?php

class InlineAsset extends Asset
{
	public function __construct($src)
	{
		parent::__construct($src);

		$src = ($this->isRemote()) ? $src : public_path().'/'.$src;
		$src = file_get_contents($src);

		switch ($this->type()) {
			case 'css':
				$this->src = '<style>'.$src.'</style>';
				break;
			case 'js':
				$this->src = '<script>'.$src.'</script>';
				break;			
		}
	}
}
