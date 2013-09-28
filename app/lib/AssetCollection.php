<?php

class AssetCollection
{
	protected $branch = 'dev';
	protected $data;

	public function __construct()
	{
		$this->config = include app_path().'/config/asset.php';
	}

	public function dev()
	{
		$this->branch = 'dev';

		return $this;
	}

	public function master()
	{
		$this->branch = 'master';

		return $this;
	}

	public function getBranch($array)
	{
		return $array[$this->branch];
	}

	public function getFiles()
	{
		return $this->config;
	}

	public function getAsset($array)
	{
		$array = $this->getBranch($array);
		
		if ($array['inline'] === true) {
			$asset = new InlineAsset($array['src']);
		} else {
			$asset = new LinkedAsset($array['src']);
		}

		return $asset;
	}

	public function build()
	{
		$assets = [];

		foreach($this->getFiles() as $asset) {
			$assets[] = $this->getAsset($asset);
		}

		return $assets;
	}
}