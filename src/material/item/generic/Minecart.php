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

class MinecartItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(MINECART, 0, $count, "Minecart");
		$this->isActivable = true;
	}
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($target->getID() !== 66 and $target->getID() !== 27){
			return;
		}
		$server = ServerAPI::request();
		$data = [
			"x" => $target->getX(), 
			"y" => $target->getY() + 0.8, 
			"z" => $target->getZ(),
			];
		$e = $server->api->entity->add($level, ENTITY_OBJECT, OBJECT_MINECART, $data);
		$server->api->entity->spawnToAll($e);
		if(($player->gamemode & 0x01) === 0x00){
			$player->removeItem($this->getID(), $this->getMetadata(), 1, false);
		}
	}
}