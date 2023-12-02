<?php

class SpawnEggItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(SPAWN_EGG, $meta, $count, "Spawn Egg");
		$this->meta = $meta;
		$this->isActivable = true;
	}
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		
		if($target instanceof MonsterSpawnerBlock){
			$tile = ServerAPI::request()->api->tile->get($target);
			if($tile instanceof Tile){
				$tile->data["EntityId"] = $this->meta;
				//TODO update tile somehow
			}else{
				ConsoleAPI::warn("No tile was found at $target!");
			}
			return false;
		}
		
		$ageable = $this->meta === MOB_CHICKEN || $this->meta === MOB_COW || $this->meta === MOB_SHEEP || $this->meta === MOB_PIG;
		$data = array(
			"x" => $block->x + 0.5,
			"y" => $block->y,
			"z" => $block->z + 0.5,
			"IsBaby" => $ageable ? Utils::chance(5) ? 1 : 0 : 0
		);
		$e = ServerAPI::request()->api->entity->add($block->level, ENTITY_MOB, $this->meta, $data);
		ServerAPI::request()->api->entity->spawnToAll($e);
		if(($player->gamemode & 0x01) === 0){
			-- $this->count;
		}
		return true;
	}
}