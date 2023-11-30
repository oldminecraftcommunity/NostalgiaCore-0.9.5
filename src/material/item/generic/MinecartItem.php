<?php

class MinecartItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(MINECART, 0, $count, "Minecart");
		$this->isActivable = true;
		$this->maxStackSize = 1;
	}
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($target->getID() !== 66 and $target->getID() !== 27){
			return;
		}
		$server = ServerAPI::request();
		$data = [
			"x" => $target->getX() + 0.5,
			"y" => $target->getY() + 0.8,
			"z" => $target->getZ() + 0.5,
		];
		$e = $server->api->entity->add($level, ENTITY_OBJECT, OBJECT_MINECART, $data);
		$server->api->entity->spawnToAll($e);
		if(($player->gamemode & 0x01) === 0x00){
			$player->removeItem($this->getID(), $this->getMetadata(), 1, false);
		}
	}
}