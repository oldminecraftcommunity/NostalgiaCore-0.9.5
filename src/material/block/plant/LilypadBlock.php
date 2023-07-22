<?php

class LilypadBlock extends FlowableBlock{
    public function __construct($meta = 0){
        parent::__construct(LILY_PAD, 0, "Lily Pad");
        $this->isSolid = false;
		$this->isFullBlock = false;
    }

    public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){//TODO: directions & only on water placement, im too lazy to make it cuz it's 0:17
        $this->level->setBlock($block, $this, true, false, true);
    }
}