<?php

class Leaves2Block extends TransparentBlock{
    public function __construct($meta = 0){
		parent::__construct(LEAVES2, $meta, "Leaves2");
		$names = array(
			0 => "Acacia Leaves",
			1 => "Dark Oak Leaves",
		);
		$this->name = $names[$this->meta & 0x02];
        $this->hardness = 1;
	}
    
	private function createIndex($x, $y, $z){
		return $index = $x.".".$y.".".$z;
	}

	private function findLog(Block $pos, array $visited, $distance){ //port from newest pocketmine
		$index = $this->createIndex($pos->x, $pos->y, $pos->z);
		if(isset($visited[$index])){
			return false;
		}
		$visited[$index] = true;

		$block = $this->level->getBlock($pos);
		if($block instanceof WoodBlock or $block instanceof Log2Block){ //type doesn't matter
			return true;
		}

		if($block->getId() === $this->getId() && $distance <= 4){
			foreach(range(2, 5) as $side){
				if($this->findLog($pos->getSide($side), $visited, $distance + 1)){ //recursion i guess?
					return true;
				}
			}
		}
		return false;
	}

    public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if(($this->meta & 0b00001100) === 0){
				$this->meta |= 0x08;
				$this->level->setBlock($this, $this, false, false, true);
				return BLOCK_UPDATE_RANDOM;
			}
		}elseif($type === BLOCK_UPDATE_RANDOM){
			if(($this->meta & 0b00001100) === 0x08){
				$this->meta &= 0x02;
				$visited = array();
				$check = 0;
				if($this->findLog($this, $visited, 0) !== true){
					$this->level->setBlock($this, new AirBlock(), false, false, true);
					if(mt_rand(1, 20) === 1){ //Saplings
						ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem(SAPLING, $this->meta + 2 & 0x05, 1));
					}
					if(($this->meta & 0x02) === 1 and mt_rand(1, 200) === 1){ //Apples
						ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem(APPLE, 0, 1));
					}
					return BLOCK_UPDATE_NORMAL;
				}
			}
		}
		return false;
	}

    public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$this->meta |= 0x04;
		$this->level->setBlock($this, $this, true, false, true);
	}
	
	public function getDrops(Item $item, Player $player){
		$drops = array();
		if($item->isShears()){
			$drops[] = array(LEAVES2, $this->meta & 0x03, 1);
		}else{
			if(mt_rand(1, 20) === 1){ //Saplings
				$drops[] = array(SAPLING, $this->meta + 2 & 0x05, 1);
			}
			if(($this->meta & 0x03) === 1 and mt_rand(1, 100) === 1){ //Apples
				$drops[] = array(APPLE, 0, 1);
			}
		}
		return $drops;
	}
}