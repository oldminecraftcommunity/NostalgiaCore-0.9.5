<?php

class RailBlock extends FlowableBlock{
	public function __construct($meta = 0){
		parent::__construct(RAIL, 0, "Rail");
		$this->hardness = 0.7;
		$this->isFullBlock = false;		
		$this->isSolid = true;
		$this->meta = $meta;
	}
	
	public static $shouldconnectrails = false;
	
	private function isRailBlock($id){ 
        switch($id){
            case RAIL:
            case POWERED_RAIL:
                return true;
            default:
                return false;
        }
    }
	
	private function isValidRailMeta($meta){ 
        return !($meta < 0 || $meta > 10);
    }
	
	private function canConnectRail($block) { 
        if(!($block instanceof RailBlock)) return null;
        if($this->distanceSquared($block) > 2) return null;
        $result = $this->checkRail($this);
        if(count($result) === 2) return null;
        return $result;
    }
	
	private function checkRail($rail){//fixed
        if(!($rail instanceof RailBlock)) return null;
        $damage = $rail->meta;
        if ($damage < 0 || $damage > 10) return null;
		$delta = array(
			array(array(0, 1), array(0, -1)),
			array(array(1, 0), array(-1, 0)),
			array(array(1, 0), array(-1, 0)),
			array(array(1, 0), array(-1, 0)),
			
			array(array(0, 1), array(0, -1)),
			array(array(0, 1), array(0, -1)),
			array(array(1, 0), array(0, 1)),
			array(array(0, 1), array(-1, 0)),
			
			array(array(-1, 0), array(0, -1)),
			array(array(0, -1), array(1, 0))
		);
        $deltaY = array(0, 1, -1);
        $blocks = $delta[$damage];
        $connected = array();
		
        foreach($deltaY as $y){
            $v3 = new Vector3(
                $rail->getFloorX() + $blocks[0][0],
                $rail->getFloorY() + $y,
                $rail->getFloorZ() + $blocks[0][1]
            );
            $idToConnect = $rail->level->getBlock(v3.getFloorX(), v3.getFloorY(), v3.getFloorZ())->getID();
            $metaToConnect = $rail->level->getBlock(v3.getFloorX(), v3.getFloorY(), v3.getFloorZ())->getMetadata();
            if (!$this->isRailBlock($idToConnect) || !$this->isValidRailMeta($metaToConnect)) continue;
            $xDiff = $damage - $v3->getFloorX();
            $zDiff = $damage - $v3->getFloorZ();
            foreach($blocks as $xz) {
                if($xz[0] !== xDiff || $xz[1] !== zDiff) continue;
                array_push($connected[], $v3);
            }
        }
        foreach($deltaY as $y){
            $v3 = new Vector3(
                $rail->getFloorX() + $blocks[1][0],
                $rail->getFloorY() + $y,
                $rail->getFloorZ() + $blocks[1][1]
            );
            $idToConnect = $rail->level->getBlock(v3.getFloorX(), v3.getFloorY(), v3.getFloorZ())->getID();
            $metaToConnect = $rail->level->getBlock(v3.getFloorX(), v3.getFloorY(), v3.getFloorZ())->getMetadata();
            if(!$this->isRailBlock($idToConnect) || !$this->isValidRailMeta($metaToConnect)) continue;
            $xDiff = $damage - $v3.getFloorX();
            $zDiff = $damage - $v3.getFloorZ();
            foreach($blocks as $xz){
                if ($xz[0] !== $xDiff || $xz[1] !== $zDiff) continue;
                array_push($connected[], $v3);
            }
        }
        return $connected;
    }
	
	private function connectRail($rail){
        $connected = $this->canConnectRail($rail);
        if ($connected === null || count($connected) === 0) return;
        if(count($connected) === 1){
            $v3 = $connected[0]->subtract($this);
            $this->meta = ($v3->y !== 1) ? ($v3->x === 0 ? 0 : 1) : (int) ($v3->z === 0 ? ($v3->x / -2) + 2.5 : ($v3->z / 2) + 4.5);
        }elseif(count(connected) === 2){
            $subtract = array(new Vector3(0, 0, 0),new Vector3(0, 0, 0));
            for ($i = 0; $i < count($connected); $i++) {
                $subtract[$i] = $connected[$i]->subtract($this);
            }
            if (abs($subtract[0]->x) === abs($subtract[1]->z) && abs($subtract[1]->x) === abs($subtract[0]->z)){
                $v3 = $connected[0]->subtract($this)->add($connected[1]->subtract($this));
                $this->meta = $v3->x === 1 ? ($v3->z === 1 ? 6 : 9) : ($v3->z === 1 ? 7 : 8);
            }elseif ($subtract[0]->y === 1 || $subtract[1]->y === 1){
                $v3 = $subtract[0]->y === 1 ? $subtract[0] : $subtract[1];
                $this->meta = $v3->x === 0 ? ($v3->z === -1 ? 4 : 5) : ($v3->x === 1 ? 2 : 3);
            }else{
                $this->meta = $subtract[0]->x === 0 ? 0 : 1;
            }
        }
        $this->level->setBlock($rail, new RailBlock($this.getDamage()), true, true);
    }

	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() !== AIR and $down instanceof SolidBlock){
			//Rail connection(ported from nukkit)
			if(RailBlock::$shouldconnectrails){
				$arrayXZ = array(array(1, 0),array(0, 1),array(-1, 0),array(0, -1));
				$arrayY = array(0, 1, -1);
				$connected = array();
				foreach($arrayXZ as $xz) {
					$x = $xz[0];
					$z = $xz[1];
					foreach($arrayY as $y){
						$v3c = new Vector3($x, $y, $z);
						$v3 = $v3c->add($this);
						$v3block = $this->level->getBlock($v3);
						if ($v3block === null) continue;
						if (!$this->isRailBlock($v3block->id) || !$this->isValidRailMeta($v3block->meta)) continue;
						if (!($v3block instanceof RailBlock)) continue;
						$this->connectRail($v3block);
						array_push($connected, $v3block);
					}
					if(count($connected) >= 2) break;
				}

				if(count($connected) === 1) {
					$v3 = $connected[0]->subtract($this);
					$this->meta = ($v3->y !== 1) ? ($v3->x === 0 ? 0 : 1) : (int) ($v3->z === 0 ? ($v3->x / -2) + 2.5 : ($v3->z / 2) + 4.5);
				}elseif(count($connected) === 2){
					$subtract = array(new Vector3(0, 0, 0),new Vector3(0, 0, 0));
					for($i = 0; $i < count($connected); $i++){
						$subtract[$i] = $connected[$i]->subtract($this);
					}
					if(abs($subtract[0]->x) === abs($subtract[1]->z) && abs($subtract[1]->x) === abs($subtract[0]->z)) {
						$v3 = $connected[0]->subtract($this)->add($connected[1]->subtract($this));
						$this->meta = $v3->x === 1 ? ($v3->z === 1 ? 6 : 9) : ($v3->z === 1 ? 7 : 8);
					}elseif($subtract[0]->y === 1 || $subtract[1]->y === 1) {
						$v3 = $subtract[0]->y == 1 ? $subtract[0] : $subtract[1];
						$this->meta = $v3->x === 0 ? ($v3->z === -1 ? 4 : 5) : ($v3->x === 1 ? 2 : 3);
					}else{
						$this->meta = $subtract[0]->x === 0 ? 0 : 1;
					}
				}
			}
			//End of Logic
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		} 
		return false;
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->getID() === AIR){//Replace with common break method
				ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem($this->id, $this->meta, 1));
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				return BLOCK_UPDATE_NORMAL;
			}	
		}
		return false;
	}
	
}