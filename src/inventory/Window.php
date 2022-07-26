<?php

define("WINDOW_CHEST", 0);
define("WINDOW_WORKBENCH", 1);
define("WINDOW_FURNACE", 2);
define("WINDOW_STONECUTTER", 3);

class Window{

	private $server;

	public function __construct(){
		$this->server = ServerAPI::request();
	}
}