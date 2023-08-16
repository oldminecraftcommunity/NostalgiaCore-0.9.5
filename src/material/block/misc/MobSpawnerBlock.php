<?php

class MobSpawnerBlock extends SolidBlock
{
	
	public function __construct($meta = 0){
		parent::__construct(MONSTER_SPAWNER, $meta, "Mob Spawner");
		$this->isActivable = true;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$api = ServerAPI::request();
		$tile = $api->api->tile->add($this->level, TILE_MOB_SPAWNER, $this->x, $this->y, $this->z, [
			"id" => TILE_MOB_SPAWNER,
			"x" => $this->x,
			"y" => $this->y,
			"z" => $this->z,
			"EntityId" => MOB_SPIDER, //TODO vanilla values
			"Delay" => 5,
			"MinSpawnDelay" => 20,
			"MaxSpawnDelay" => 80,
			"SpawnCount" => 4,
			"MaxNearbyEntities" => 0,
			"RequiredPlayerRange" => 0,
			"SpawnRange" => 4
		]);
		parent::place($item, $player, $block, $target, $face, $fx, $fy, $fz);
	}
}

