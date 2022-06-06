<?php
/*
TODO:
move methods
*/
class Pig extends Animal{
	const TYPE = 12;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		console("A constructor which indicates it works! ".":".$eid.":".$class.":".$type);
		parent::__construct($level, $eid, $class, $type, $data);
	}
}