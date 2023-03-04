<?php

final class Structures
{
	public static $SMALLFARM_VILLAGE;
	public static function initialize(){
		self::$SMALLFARM_VILLAGE = new SmallFarmStructure();
	}
	
}

