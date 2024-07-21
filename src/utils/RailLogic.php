<?php

class RailLogic
{
	public $x, $y, $z;
	public $level;
	
	/**
	 * @var Vector3[]
	 */
	public $railPositions = [];
	public $isStraight;
	public function __construct(RailBaseBlock $rail){
		$id = $rail->getID();
		$meta = $rail->getMetadata();
		$this->level = $rail->level;
		$this->x = $rail->x;
		$this->y = $rail->y;
		$this->z = $rail->z;
		$this->isStraight = $id === POWERED_RAIL;
		
		$this->updateConnections($meta);
	}
	public function getRail($v){
		if(($b = $this->level->getBlock($v)) instanceof RailBaseBlock){ //TODO git rid of getBlock
			return new RailLogic($b);
		}elseif(($b = $this->level->getBlockWithoutVector($v->x, $v->y + 1, $v->z)) instanceof RailBaseBlock){
			return new RailLogic($b);
		}elseif(($b = $this->level->getBlockWithoutVector($v->x, $v->y - 1, $v->z)) instanceof RailBaseBlock){
			return new RailLogic($b);
		}
		
		return null;
	}
	
	public function hasRail($x, $y, $z){
		return RailBaseBlock::isRailBlock($this->level, $x, $y, $z) || RailBaseBlock::isRailBlock($this->level, $x, $y + 1, $z) || RailBaseBlock::isRailBlock($this->level, $x, $y - 1, $z);
	}
	
	public function countPotentialConnections(){
		return $this->hasRail($this->x, $this->y, $this->z - 1) + $this->hasRail($this->x, $this->y, $this->z + 1) + $this->hasRail($this->x - 1, $this->y, $this->z) + $this->hasRail($this->x + 1, $this->y, $this->z);
	}
	
	public function removeSoftConnections(){
		for($ind = 0; $ind < count($this->railPositions); ++$ind){
			$logic = $this->getRail($this->railPositions[$ind]);
			if($logic != null && $this->connectsTo($logic)){
				$this->railPositions[$ind] = new Vector3($logic->x, $logic->y, $logic->z);
			}else{
				unset($this->railPositions[$ind--]);
				$this->railPositions = array_values($this->railPositions); //reindexing
			}
		}
	}
	
	public function connectsTo(RailLogic $logic){
		foreach($this->railPositions as $rpos){
			if(($rpos->x === $logic->x) && ($rpos->z === $logic->z)){
				return true;
			}
		}
		return false;
	}
	
	public function canConnectTo(RailLogic $rail){
		return $this->connectsTo($rail) ? true : (count($this->railPositions) == 2 ? false : (empty($this->railPositions) ? true : true));
	}
	
	public function hasNeighborRail($x, $y, $z){
		$logic = $this->getRail(new Vector3($x, $y, $z));
		if($logic === null){
			return false;
		}else{
			$logic->removeSoftConnections(); //i place $this here and was searching why isnt it working correctly for 2 hours
			return $logic->canConnectTo($this);
		}
		
	}
	
	public function place($b, $b1){
		$hasZneg = $this->hasNeighborRail($this->x, $this->y, $this->z - 1);
		$hasZpos = $this->hasNeighborRail($this->x, $this->y, $this->z + 1);
		$hasXneg = $this->hasNeighborRail($this->x - 1, $this->y, $this->z);
		$hasXpos = $this->hasNeighborRail($this->x + 1, $this->y, $this->z);
		$state = -1;
		if(($hasZneg || $hasZpos) && !($hasXneg && $hasXpos)){
			$state = 0;
		}
		if(($hasXneg || $hasXpos) && !($hasZneg && $hasZpos)){
			$state = 1;
		}
		
		if(!$this->isStraight){
			if($hasZpos && $hasXpos && !($hasZneg && $hasXneg)) $state = 6;
			if($hasZpos && $hasXneg && !($hasZneg && $hasXpos)) $state = 7;
			if($hasZneg && $hasXneg && !($hasZpos && $hasXpos)) $state = 8;
			if($hasZneg && $hasXpos && !($hasZpos && $hasXneg)) $state = 9;
		}
		
		if($state === -1){
			if($hasZneg || $hasZpos) $state = 0;
			if($hasXneg || $hasXpos) $state = 1;
			
			if(!$this->isStraight){
				if($b){
					if($hasZpos && $hasXpos) $state = 6;
					if($hasXneg && $hasZpos) $state = 7;
					if($hasXpos && $hasZneg) $state = 9;
					if($hasZneg && $hasXneg) $state = 8;
				}else{
					if($hasZneg && $hasXneg) $state = 8;
					if($hasXpos && $hasZneg) $state = 9;
					if($hasXneg && $hasZpos) $state = 7;
					if($hasZpos && $hasXpos) $state = 6;
				}
			}
		}
		

		if($state === 0){
			if(RailBaseBlock::isRailBlock($this->level, $this->x, $this->y + 1, $this->z - 1)) $state = 4;
			if(RailBaseBlock::isRailBlock($this->level, $this->x, $this->y + 1, $this->z + 1)) $state = 5;
		}elseif($state === 1){
			if(RailBaseBlock::isRailBlock($this->level, $this->x + 1, $this->y + 1, $this->z)) $state = 2;
			if(RailBaseBlock::isRailBlock($this->level, $this->x - 1, $this->y + 1, $this->z)) $state = 3;
		}elseif($state < 0) $state = 0;
		
		$this->updateConnections($state);
		$meta = $state;
		if($this->isStraight){
			$meta = $this->level->level->getBlockDamage($this->x, $this->x, $this->z) & 8 | $state;
		}
		
		if($b1 || $this->level->level->getBlockDamage($this->x, $this->y, $this->z)){
			//this.logicWorld.setBlockMetadataWithNotify(this.railX, this.railY, this.railZ, var8, 3);
			$bl = $this->level->getBlockWithoutVector($this->x, $this->y, $this->z);
			$bl->setMetadata($meta);
			$this->level->setBlock(new Vector3($this->x, $this->y, $this->z), $bl, true, false, true);
			foreach($this->railPositions as $rpos){
				$logic = $this->getRail($rpos);
				if($logic !== null){
					$logic->removeSoftConnections();
					if($logic->canConnectTo($this)){
						$logic->connectTo($this);
					}
					
				}
			}
		
		}
		
	}
	
	public function hasConnection($x, $y, $z){
		foreach($this->railPositions as $rpos){
			if($rpos->x === $x && $rpos->z === $z) return true;
		}
		return false;
	}
	
	public function connectTo(RailLogic $logic){
		$this->railPositions[] = new Vector3($logic->x, $logic->y, $logic->z);
		
		$hasZneg = $this->hasConnection($this->x, $this->y, $this->z - 1);
		$hasZpos = $this->hasConnection($this->x, $this->y, $this->z + 1);
		$hasXneg = $this->hasConnection($this->x - 1, $this->y, $this->z);
		$hasXpos = $this->hasConnection($this->x + 1, $this->y, $this->z);
		$state = -1;
		
		if($hasZneg || $hasZpos) $state = 0;
		if($hasXneg || $hasXpos) $state = 1;
		
		if(!$this->isStraight){
			if($hasZpos && $hasXpos && !($hasZneg && $hasXneg)) $state = 6;
			if($hasZpos && $hasXneg && !($hasZneg && $hasXpos)) $state = 7;
			if($hasZneg && $hasXneg && !($hasZpos && $hasXpos)) $state = 8;
			if($hasZneg && $hasXpos && !($hasZpos && $hasXneg)) $state = 9;
		}

		if($state == 0){
			if(RailBaseBlock::isRailBlock($this->level, $this->x, $this->y + 1, $this->z - 1)) $state = 4;
			if(RailBaseBlock::isRailBlock($this->level, $this->x, $this->y + 1, $this->z + 1)) $state = 5;
		}elseif($state == 1){
			if(RailBaseBlock::isRailBlock($this->level, $this->x + 1, $this->y + 1, $this->z)) $state = 2;
			if(RailBaseBlock::isRailBlock($this->level, $this->x - 1, $this->y + 1, $this->z)) $state = 3;
		}elseif($state < 0) $state = 0;
		
		$meta = $state;
		
		if($this->isStraight){
			$meta = $this->level->level->getBlockDamage($this->x, $this->x, $this->z) & 8 | $state;
		}
		
		//$b = $this->level->getBlockWithoutVector($this->x, $this->y, $this->z);
		//$b->setMetadata($meta);
		//$this->level->setBlock(new Vector3($this->x, $this->y, $this->z), $b, true, false, true);
		$this->level->fastSetBlockUpdateMeta($this->x, $this->y, $this->z, $meta, true);
	}
	
	public function updateConnections($meta){
		
		$this->railPositions = [];
		
		switch($meta){
			case 0:
				$this->railPositions[] = new Vector3($this->x, $this->y, $this->z - 1);
				$this->railPositions[] = new Vector3($this->x, $this->y, $this->z + 1);
				break;
			case 1:
				$this->railPositions[] = new Vector3($this->x - 1, $this->y, $this->z);
				$this->railPositions[] = new Vector3($this->x + 1, $this->y, $this->z);
				break;
			case 2:
				$this->railPositions[] = new Vector3($this->x - 1, $this->y, $this->z);
				$this->railPositions[] = new Vector3($this->x + 1, $this->y + 1, $this->z);
				break;
			case 3:
				$this->railPositions[] = new Vector3($this->x - 1, $this->y + 1, $this->z);
				$this->railPositions[] = new Vector3($this->x + 1, $this->y, $this->z);
				break;
			case 4:
				$this->railPositions[] = new Vector3($this->x, $this->y + 1, $this->z - 1);
				$this->railPositions[] = new Vector3($this->x, $this->y, $this->z + 1);
				break;
			case 5:
				$this->railPositions[] = new Vector3($this->x, $this->y, $this->z - 1);
				$this->railPositions[] = new Vector3($this->x, $this->y + 1, $this->z + 1);
				break;
			case 6:
				$this->railPositions[] = new Vector3($this->x + 1, $this->y, $this->z);
				$this->railPositions[] = new Vector3($this->x, $this->y, $this->z + 1);
				break;
			case 7:
				$this->railPositions[] = new Vector3($this->x - 1, $this->y, $this->z);
				$this->railPositions[] = new Vector3($this->x, $this->y, $this->z + 1);
				break;
			case 8:
				$this->railPositions[] = new Vector3($this->x - 1, $this->y, $this->z);
				$this->railPositions[] = new Vector3($this->x, $this->y, $this->z - 1);
				break;
			case 9:
				$this->railPositions[] = new Vector3($this->x + 1, $this->y, $this->z);
				$this->railPositions[] = new Vector3($this->x, $this->y, $this->z - 1);
				break;
		}
	}
}

