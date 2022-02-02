<?php
class Config {
	protected $file;

	public function read($file)
	{
		if(file_exists($file)) {
			$this->file = require $file;
		}

		return false;
	}

	public function get($key)
	{
		$data = $this->file;
		$segments = explode('/', $key);

		foreach($segments as $segment){
			if(isset($data[$segment])){
				$data = $data[$segment];
			} else {
				break;
			}
		}

		return $data;
	}
}