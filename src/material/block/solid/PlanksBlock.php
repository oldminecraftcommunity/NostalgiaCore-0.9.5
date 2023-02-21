<?php

class PlanksBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(PLANKS, $meta, "Wooden Planks");
		$names = array(
			WoodBlock::OAK => "Oak Wooden Planks",
			WoodBlock::SPRUCE => "Spruce Wooden Planks",
			WoodBlock::BIRCH => "Birch Wooden Planks",
			WoodBlock::JUNGLE => "Jungle Wooden Planks",
			4 => "Acacia Wooden Planks",
			5 => "Dark Oak Wooden Planks",
		);
		$this->name = $names[$this->meta];
		$this->hardness = 15;
	}
	
}