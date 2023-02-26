<?php

class MonsterSpawnerBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(MONSTER_SPAWNER, $meta, "Monster Spawner");
		$this->hardness = 5;
	}
	
	public function getDrops(Item $item, Player $player){
        return [];
    }
}