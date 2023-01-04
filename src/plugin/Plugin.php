<?php

interface Plugin{
	
	public function __construct(ServerAPI $api, $server = false);
	
	public function init();
	
	//public function __destruct(); useless
}
