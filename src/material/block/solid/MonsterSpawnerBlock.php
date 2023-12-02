<?php

class MonsterSpawnerBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(MONSTER_SPAWNER, $meta, "Monster Spawner");
		$this->hardness = 5;
	}
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		parent::place($item, $player, $block, $target, $face, $fx, $fy, $fz);
		ServerAPI::request()->api->tile->add($this->level, TILE_MOB_SPAWNER, $this->x, $this->y, $this->z, [
			"EntityId" => 0,
			"id" => TILE_MOB_SPAWNER,
			"x" => $this->x,
			"y" => $this->y,
			"z" => $this->z,
		]);
	}
	public function getDrops(Item $item, Player $player){
        return [];
    }
}