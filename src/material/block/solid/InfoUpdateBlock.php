<?php

class InfoUpdateBlock extends SolidBlock{
	public static $blockID;
	public function __construct(){
		parent::__construct(INFO_UPDATE, 0, "tile.info_update.name<");
		$this->breakable = true;
		$this->hardness = 0;
	}
	
}