<?php

class LavaBlock extends LiquidBlock implements LightingBlock{
	public function __construct($meta = 0){
		parent::__construct(LAVA, $meta, "Lava");
		$this->hardness = 0;
	}
	
		public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$ret = $this->level->setBlock($this, $this, true, false, true);
		ServerAPI::request()->api->block->scheduleBlockUpdate(clone $this, 40, BLOCK_UPDATE_NORMAL);
		return $ret;
	}
	
	public function getMaxLightValue(){
		return 15;
	}
	
	public function getSourceCount(){
		$count = 0;
		for($side = 2; $side <= 5; ++$side){
			if($this->getSide($side) instanceof LavaBlock ){
				$b = $this->getSide($side);
				$level = $b->meta & 0x06;
				if($level == 0x00){
					$count++;
				}
			}
		}
		return $count;
	}
	
	public function checkWater(){
		for($side = 0; $side <= 5; ++$side){
			$b = $this->getSide($side);
			if($b instanceof WaterBlock){
				$level = $this->meta & 0x06;
				if($level == 0x00){
					$this->level->setBlock($b, new ObsidianBlock(), false, false, true);
				}else{
					$this->level->setBlock($b, new CobblestoneBlock(), false, false, true);
				}
			}
		}
	}
	
	public function getFrom(){
		for($side = 0; $side <= 5; ++$side){
			$b = $this->getSide($side);
			if($b instanceof LavaBlock){
				$tlevel = $b->meta & 0x06;
				$level = $this->meta & 0x06;
				if( ($tlevel + 2) == $level || ($side == 0x01 && $level == 0x01 ) || ($tlevel == 6 && $level == 6 )){
					return $b;
				}
			}
		}
		return null;
	}
		
	public function onUpdate($type){
		//return false;
		$newId = $this->id;
		$level = $this->meta & 0x06;
		if($type !== BLOCK_UPDATE_NORMAL){
			return false;
		}
		
		if($this->checkWater()){
			return;
		}
		
		$falling = $this->meta >> 3;
		$down = $this->getSide(0);
		
		$from = $this->getFrom();
		if($from !== null || $level == 0x00){
			if($down instanceof AirBlock || $down instanceof LavaBlock){
				$this->level->setBlock($down, new LavaBlock(0x01), false, false, true);
				ServerAPI::request()->api->block->scheduleBlockUpdate($down, 40, BLOCK_UPDATE_NORMAL);
			}elseif($level !== 0x06){
				for($side = 2; $side <= 5; ++$side){
					$b = $this->getSide($side);
					if($b instanceof LavaBlock){
						
					}elseif($b->isFlowable === true){
						$this->level->setBlock($b, new LavaBlock( min($level + 2,6) ), false, false, true);
						ServerAPI::request()->api->block->scheduleBlockUpdate($b, 40, BLOCK_UPDATE_NORMAL);
					}
				}
			}
		}else{
			//Extend Remove for Left Lavas
			for($side = 2; $side <= 5; ++$side){
				$sb = $this->getSide($side);
				if($sb instanceof LavaBlock){
					$tlevel = $sb->meta & 0x06;
					if($tlevel != 0x00){
						for ($s = 0; $s <= 5; $s++) {
							$ssb = $sb->getSide($s);
							ServerAPI::request()->api->block->scheduleBlockUpdate($ssb, 40, BLOCK_UPDATE_NORMAL);
						}
						$this->level->setBlock($sb, new AirBlock(), false, false, true);
					}
				}
				$b = $this->getSide(0)->getSide($side);
				if($b instanceof LavaBlock){
					$tlevel = $b->meta & 0x06;
					if($tlevel != 0x00){
						for ($s = 0; $s <= 5; $s++) {
							$ssb = $sb->getSide($s);
							ServerAPI::request()->api->block->scheduleBlockUpdate($ssb, 40, BLOCK_UPDATE_NORMAL);
			  			}
						$this->level->setBlock($b, new AirBlock(), false, false, true);
					}
				}
				//ServerAPI::request()->api->block->scheduleBlockUpdate(new Position($b, 0, 0, $this->level), 10, BLOCK_UPDATE_NORMAL);
			}

			$this->level->setBlock($this, new AirBlock(), false, false, true);
		}
		return false;
	}	
	
}
