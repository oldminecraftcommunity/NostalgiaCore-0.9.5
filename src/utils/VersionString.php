<?php
//TODO remove at all
class VersionString{
  
	private $development = false;

	public function __construct($version = MAJOR_VERSION){
		$this->development = Utils::endsWith($version, "dev");
	}

	public function isDev(){
		return $this->development === true;
	}

	public function __toString(){
		return MAJOR_VERSION;
	}
}