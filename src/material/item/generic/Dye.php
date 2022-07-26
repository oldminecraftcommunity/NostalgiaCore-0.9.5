<?php

class DyeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(DYE, $meta, $count, "Dye");
		$names = array(
			0 => "Inc Sac",
			1 => "Rose Red",
			2 => "Cactus Green",
			3 => "Cocoa Beans",
			4 => "Lapis Lazuli",
			5 => "Purple Dye",
			6 => "Cyan Dye",
			7 => "Light Gray Dye",
			8 => "Gray Dye",
			9 => "Pink Dye",
			10 => "Lime Dye",
			11 => "Dandelion Yellow",
			12 => "Light Blue Dye",
			13 => "Magenta Dye",
			14 => "Orange Dye",
			15 => "Bone Meal",
		);
		$this->name = $names[$this->meta];
	}
}