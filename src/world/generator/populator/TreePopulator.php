<?php
class TreePopulator extends Populator{
	public $level;
	public $randomAmount;
	public $baseAmount;
	
	public function setRandomAmount($amount){
		$this->randomAmount = $amount;
	}
	
	public function setBaseAmount($amount){
		$this->baseAmount = $amount;
	}
	
	public function populate(Level $level, $chunkX, $chunkZ, Random $random){
		$this->level = $level;
		$amount = $random->nextRange(0, $this->randomAmount + 1) + $this->baseAmount;
		for($i = 0; $i < $amount; ++$i){
			$x = $random->nextRange($chunkX << 4, ($chunkX << 4) + 15);
			$z = $random->nextRange($chunkZ << 4, ($chunkZ << 4) + 15);
			$y = $this->getHighestWorkableBlock($x, $z);
			if($y === -1){
				continue;
			}
			if($random->nextFloat() > 0.75){
				$meta = SaplingBlock::BIRCH;
			}elseif(($random->nextFloat() < 0.75) and ($random->nextFloat() > 0.25)){
				$meta = SaplingBlock::OAK;
			}else{
				$meta = SaplingBlock::JUNGLE;
			}
			TreeObject::growTree($this->level, new Vector3($x, $y, $z), $random, $meta);
		}
	}
	
	public function getHighestWorkableBlock($x, $z){
		for($y = 128; $y > 0; --$y){
			$b = $this->level->level->getBlockID($x, $y, $z);
			if($b !== DIRT and $b !== GRASS){
				if(--$y <= 0){
					return -1;
				}
			}else{
				break;
			}
		}
		return ++$y;
	}
}