<?php

class BrownMushroomSolidBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(BROWN_MUSHROOM_BLOCK, $meta, "Mushroom");
		$this->hardness = 0.2;
	}

    public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
        //todo
		$this->level->setBlock($this, $this, true, false, true);
	}
	
	public function getDrops(Item $item, Player $player){
        return [
            [BROWN_MUSHROOM, 0, mt_rand(0, 2)]
        ];
    }
}