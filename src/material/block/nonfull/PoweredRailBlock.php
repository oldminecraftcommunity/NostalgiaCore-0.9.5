<?php
require_once("RailBaseBlock.php");
class PoweredRailBlock extends RailBaseBlock{
	public function __construct($meta = 0){
		parent::__construct(POWERED_RAIL, 0, "PoweredRailBlock");
		$this->hardness = 0.7;
		$this->isFullBlock = false;
		$this->isSolid = false;
	}
	
}