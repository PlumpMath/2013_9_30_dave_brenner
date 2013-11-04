<?php namespace Williamstein92\QueryString;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;

class QueryString
{
	protected $id;
	protected $key_length = 16;
	protected $value_length = 32;
	protected static $query;
	protected static $map;

	public function __construct()
	{
		$this->id = 'sid';
	}

	public function boot()
	{
		if (isset($_GET[$this->id])) $str = $_GET[$this->id]; else return false;

		if (static::$query !== $str) {
			static::$query = $str;

			$chunks = $this->chunk($str);
			static::$map = $chunks;
		}

		return true;
	}

	public function get($key)
	{
		if ($this->boot()) {
			return static::$map[$key];
		}

		return false;
	}

	public function set($array)
	{
		$_out = $this->id.'=';

		foreach($array as $key => $value) {
			$_out .= $this->keyEncode($key).$this->valueEncode($value);
		}

		return $_out;
	}

	public function chunk($str)
	{
		$_out = [];

		$chunk_number = $this->measure($str);
		$chunks = str_split($str, $this->length());

		foreach($chunks as $chunk) {
			$_out[$this->key($chunk)] = $this->value($chunk);
		}

		return $_out;
	}

	public function key($str)
	{
		return $this->keyDecode(substr($str, 0, $this->keyLength()));
	}

	public function value($str)
	{
		return $this->valueDecode(substr($str, $this->keyLength()));
	}

	public function length()
	{
		return $this->keyLength() + $this->valueLength();
	}

	public function keyLength()
	{
		return $this->key_length;
	}

	public function valueLength()
	{
		return $this->value_length;
	}

	public function measure($str)
	{
		return strlen($str) / $this->length();
	}

	public function encode()
	{
		$this->boot();

		return static::$map;
	}

	public function keyEncode($key)
	{
		if (strlen($key) > 8) return;

		$chars = str_split($key);

		foreach($chars as $i => $char) {
			$chars[$i] = dechex(ord($char));
		}

		$key = implode('', $chars);
		$pad_length = 8 - strlen($key) / 2;

		for ($i = $pad_length; $i > 0; $i--) $key .= 'gg';

		return $key;
	}

	public function keyDecode($key)
	{
		$_out = [];
		$chars = str_split($key, 2);

		foreach($chars as $char) {
			if ($char !== 'gg') $_out[] = chr(hexdec($char));
		}

		return implode('', $_out);
	}

	public function valueEncode($value)
	{
		if (strlen($value) > 16) return;

		$chars = str_split($value);

		foreach($chars as $i => $char) {
			$char = dechex(ord($char));

			if (strlen($char) < 2) $char = '0'.$char;
		}

		$value = implode('', $chars);
		$pad_length = 16 - strlen($value) / 2;

		for ($i = $pad_length; $i > 0; $i--) $value .= 'gg';

		return $value;
	}

	public function valueDecode($value)
	{
		return $this->keyDecode($value);
	}
}