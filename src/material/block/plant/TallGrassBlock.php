<?php

class TallGrassBlock extends FlowableBlock{
	public function __construct($meta = 1){
		parent::__construct(TALL_GRASS, $meta, "Grass");
		$this->isReplaceable = true;
		$names = array(
			0 => "Dead Shrub",
			1 => "Grass",
			2 => "Fern",
		);
		$this->name = $names[$this->meta & 0x02];
		$this->hardness = 0;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->isTransparent === true){ //Replace with common break method
				$this->level->setBlock($this, new AirBlock(), false, false, true);
			  	if(Utils::chance(15)) ServerAPI::request()->api->entity->drop(new Position($this->x + 0.5, $this->y, $this->z + 0.5, $this->level), BlockAPI::getItem(WHEAT_SEEDS));
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function getDrops(Item $item, Player $player){
		$drops = array();
		if($item->isShears()) $drops[] = array($this->id, $this->meta & 0x03, 1);
		elseif(Utils::chance(15)) $drops[] = array(WHEAT_SEEDS, 0, 1);
		return $drops;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() == 2 or $down->getID() == 3){
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		} 
		return false;
	}

}
