<?php

abstract class Living extends Entity implements Pathfindable{
	
	public static $despawnMobs, $despawnTimer, $entityPushing = false;
	
	public static $pathfinderTest = false;
	
	
	/**
	 * @var Entity $target
	 * @var EntityAI $ai
	 */
	public $target, $ai;
	public $pathFinder, $path = null, $currentIndex = 0, $currentNode, $pathFollower;
	public $ticksExisted = 0;
	
	public $landMovementFactor = 0.1;
	public $jumpMovementFactor = 0.02;
	public $aiMoveSpeed;
	
	public $renderYawOffset = 0.0; //used by head rotation, TODO better name
	public $jumping, $jumpTicks;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		$this->target = false;
		$this->ai = new EntityAI($this);
		$this->pathFinder = new TileNavigator($this);
		$this->pathFollower = new PathFollower($this);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->canBeAttacked = true;
		$this->hasGravity = true;
		$this->hasKnockback = true;
		
		//if(self::$despawnMobs) $this->server->schedule(self::$despawnTimer, [$this, "close"]); //900*20
	}
	
	public function isPickable(){
		return !$this->dead;
	}
	
	public function fall(){
		$dmg = ceil($this->fallDistance - 3);
		if($dmg > 0){
			$this->harm($dmg, "fall");
		}
	}
	
	public function handlePlayerSearcher(Player $player, $dist){
		
	}
	
	public function getAIMoveSpeed(){
		return $this->aiMoveSpeed;
	}
	
	public function getVerticalFaceSpeed(){
		return 40; //unused in 0.8 but may be useful in 0.9/0.10
	}
	
	public function setAIMoveSpeed($speed){
		$this->aiMoveSpeed = $speed;
		$this->moveForward = $speed;
	}
	
	public function hasPath(){
		return $this->path != null;
	}
	public function eatGrass(){}
	
	public function close(){
		parent::close();
		unset($this->pathFollower->entity);
		unset($this->ai->entity);
		unset($this->ai->mobController->entity);
		unset($this->ai);
		unset($this->parent);
		unset($this->pathFinder->entity);
	}
	
	public function canBeShot(){
		return true;
	}
	
	public function isPushable(){
		return !$this->dead;
	}
	
	public function collideHandler(){
		$bb = $this->boundingBox->expand(0.2, 0, 0.2);
		$minChunkX = ((int)($bb->minX)) >> 4;
		$minChunkZ = ((int)($bb->minZ)) >> 4;
		$maxChunkX = ((int)($bb->minX)) >> 4;
		$maxChunkZ = ((int)($bb->minZ)) >> 4;
		
		//TODO also index by chunkY?
		for($chunkX = $minChunkX; $chunkX <= $maxChunkX; ++$chunkX){
			for($chunkZ = $minChunkZ; $chunkZ <= $maxChunkZ; ++$chunkZ){
				$ind = "$chunkX $chunkZ";
				foreach($this->level->entityListPositioned[$ind] ?? [] as $entid){
					if(($this->level->entityList[$entid] ?? null) instanceof Entity){
						if($this->level->entityList[$entid]->isPushable() && $bb->intersectsWith($this->level->entityList[$entid]->boundingBox)){
							$this->level->entityList[$entid]->applyCollision($this, true);
						}
					}
				}
			}
		}
	}
	
	public function update($now){
		if(self::$despawnMobs && ++$this->ticksExisted > self::$despawnTimer){
			$this->close();
			return;
		}
		if($this->closed) return;
	
		$check = $this->level->mobSpawner->checkDespawn($this);
		if($check){
			$this->close();
			return;
		}
		parent::update($now);
	}
	
	public $pathEIDS = [];
	private static $lastPathEID = 10000000;
	public static $pathfind = true;
	public function updateEntityMovement(){
		if(!$this->dead && Entity::$allowedAI && $this->idleTime <= 0 && !self::$pathfinderTest) {
			$this->ai->updateTasks();
		}
		if(self::$pathfinderTest){
			if(!$this->hasPath()){
				//$target = new PathTileXYZ($this->x + mt_rand(-10, 10), $this->y + mt_rand(-1, 1), $this->z + mt_rand(-10, 10), $this->level);
				$pl = null;
				if(count($this->level->players) > 0){
					//$pl = array_values($this->level->players)[0];
					//$target = new PathTileXYZ($pl->entity->x, $pl->entity->y, $pl->entity->z, $this->level);
				}
				if(self::$pathfind){
					$this->path = $this->pathFinder->navigate(
						$this->level, 
						(int)$this->x, (int)$this->y, (int)$this->z, 
						//(int)$pl->entity->x, (int)$pl->entity->y, (int)$pl->entity->z, 
						(int)$this->x + mt_rand(-16, 16), (int)$this->y, (int)$this->z + mt_rand(-16, 16),
						16
					);
				}
				
				
				/*if($this->path){
					console("Found path of length ".count($this->path));
					
					foreach($this->path as $node){
						$eid = self::$lastPathEID++;
						$this->pathEIDS[] = $eid;
						
						$pk = new AddItemEntityPacket();
						$pk->eid = $eid;
						$pk->item = BlockAPI::getItem(GOLD_BLOCK, 0, 1);
						$pk->x = ($node >> 16 & 0xff) + 0.5;
						$pk->y = $node & 0xff;
						$pk->z = ($node >> 8 & 0xff) + 0.5;
						$pk->yaw = $pk->pitch = 0;
						$pk->roll = 0;
						foreach($this->level->players as $player){
							$player->dataPacket($pk);
						}
					}
				}*/
			}
			$this->pathFollower->followPath();
		}
		
		
		//not exactly here
		if($this->jumping){
			if(!$this->inWater && !$this->inLava){
				if($this->onGround && $this->jumpTicks <= 0){
					$this->jump();
					$this->jumpTicks = 10;
				}
			}else{
				$this->speedY += 0.04;
			}
		}else{
			$this->jumpTicks = 0;
		}
		
		
		$this->ai->mobController->movementTick();
		$this->ai->mobController->rotateTick();
		$this->ai->mobController->jumpTick();
		
		if(abs($this->speedX) < self::MIN_POSSIBLE_SPEED) $this->speedX = 0;
		if(abs($this->speedZ) < self::MIN_POSSIBLE_SPEED) $this->speedZ = 0;
		if(abs($this->speedY) < self::MIN_POSSIBLE_SPEED) $this->speedY = 0;
		$this->moveStrafing *= 0.98;
		$this->moveForward *= 0.98;
		$savedLandFactor = $this->landMovementFactor;
		$this->landMovementFactor *= $this->getSpeedModifer();
		$this->moveEntityWithHeading($this->moveStrafing, $this->moveForward);
		$this->landMovementFactor = $savedLandFactor;
		//Yaw rotation in 1.5 is handled in a bit different place but hopefully this will work too
		$this->ai->mobController->updateHeadYaw();
		
		if(self::$entityPushing){
			$this->collideHandler();
		}
	}
	
	public function jump(){
		$this->speedY = 0.42;
		
		//TODO also set AirBorne?
	}
	
	public function counterUpdate(){
		parent::counterUpdate();
		if($this->jumpTicks > 0) --$this->jumpTicks;
	}
	
	
	public function moveEntityWithHeading($strafe, $forward){
		if($this->inWater){ //also check is player, and can it fly or not
			$prevPosY = $this->y;
			$this->moveFlying($strafe, $forward, 0.02);
			$this->move($this->speedX, $this->speedY, $this->speedZ);
			$this->speedX *= 0.8;
			$this->speedY *= 0.8;
			$this->speedZ *= 0.8;
			$this->speedY -= 0.02;
			
			
			if($this->isCollidedHorizontally && $this->isFree($this->speedX, $this->speedY + 0.6 - $this->y + $prevPosY, $this->speedZ)){
				$this->speedY = 0.3;
			}
		}elseif($this->inLava){
			$prevPosY = $this->y;
			$this->moveFlying($strafe, $forward, 0.02);
			$this->move($this->speedX, $this->speedY, $this->speedZ);
			$this->speedX *= 0.5;
			$this->speedY *= 0.5;
			$this->speedZ *= 0.5;
			$this->speedY -= 0.02;
			
			if($this->isCollidedHorizontally && $this->isFree($this->speedX, $this->speedY + 0.6 - $this->y + $prevPosY, $this->speedZ)){
				$this->speedY = 0.3;
			}
		}else{
			$friction = 0.91;
			
			if($this->onGround){
				$friction = 0.546;
				$blockAt = $this->level->level->getBlockID(floor($this->x), floor($this->boundingBox->minY) - 1, floor($this->z));
				
				if($blockAt > 0) $friction = StaticBlock::getSlipperiness($blockAt) * 0.91;
			}
			
			$var8 = 0.16277 / ($friction*$friction*$friction);
			
			if($this->onGround){
				$var5 = $this->getAIMoveSpeed();  //in vanilla it returns either this.seed or calls getBaseSpeed(depending on useNewAi)
				$var5 *= $var8; //in vanilla it also multiplies by speedModifer
			}else{
				$var5 = $this->jumpMovementFactor;
			}
			
			$this->moveFlying($strafe, $forward, $var5);
			//recalculating friction, might be not neccessary
			$friction = 0.91;
			
			if($this->onGround){
				$friction = 0.546;
				$blockAt = $this->level->level->getBlockID(floor($this->x), floor($this->boundingBox->minY) - 1, floor($this->z));
				
				if($blockAt > 0) $friction = StaticBlock::getSlipperiness($blockAt) * 0.91;
			}
			
			if($this->isOnLadder()){
				$speedY = $this->speedY;
				$this->fallDistance = 0;
				if($speedY < -0.15) $this->speedY = -0.15;
			}
			
			$this->move($this->speedX, $this->speedY, $this->speedZ);
			
			if($this->isOnLadder() && $this->isCollidedHorizontally){
				$this->speedY = 0.2;
			}
			
			$this->speedY -= 0.08; //gravity
			
			$this->speedY *= 0.98;
			$this->speedX *= $friction;
			$this->speedZ *= $friction;
			
			if($this->isCollidedHorizontally && $this->enableAutojump){
				$this->ai->mobController->setJumping(true); //non vanilla
			}
		}
	}
	
	public function sendMoveUpdate(){
		if($this->counter % 3 != 0){
			return;
		}
		parent::sendMoveUpdate();
		
	}
}
