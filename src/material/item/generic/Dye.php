<?php

/**
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

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