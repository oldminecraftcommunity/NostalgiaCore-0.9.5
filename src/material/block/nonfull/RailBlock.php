<?php
require_once("RailBaseBlock.php");
class RailBlock extends RailBaseBlock{
	
	public static $shouldconnectrails = true;
	
	public function __construct($meta = 0){
		parent::__construct(RAIL, $meta, "Rail");
		$this->hardness = 0.7;
		$this->isFullBlock = false;
		$this->isSolid = false;
	}
	
	public function updateState(){
		//$logic = (new RailLogic($this));
		//if($logic->countPotentialConnections() == 3){
		//	$logic->place(false, false);
		//}
	}
	
}