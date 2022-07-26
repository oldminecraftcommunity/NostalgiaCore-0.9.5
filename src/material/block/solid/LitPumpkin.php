<?php

class LitPumpkinBlock extends SolidBlock implements LightingBlock{
	public function __construct($meta = 0){
		parent::__construct(LIT_PUMPKIN, $meta, "Jack o'Lantern");
		$this->hardness = 5;
	}
	
	public function getMaxLightValue(){
		return 15;
	}
	
    public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
        $faces = array(
            0 => 1,
            1 => 2,
            2 => 3,
            3 => 0,
        );
        $this->meta = $faces[$player->entity->getDirection()];
        $this->level->setBlock($block, $this, true, false, true);
        return true;
    }
}