<?php

class Slime extends Monster
{
	const TYPE = MOB_SLIME;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setName("Slime");
		/* Health formula
		 * SlimeSize = Slime::getSlimeSize(this);
  		 * return SlimeSize * SlimeSize;
		 */
	}
}

