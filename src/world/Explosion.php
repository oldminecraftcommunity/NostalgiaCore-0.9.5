<?php

class Explosion{

	public static $specialDrops = [
		GRASS => DIRT,
		STONE => COBBLESTONE,
		COAL_ORE => COAL,
		DIAMOND_ORE => DIAMOND,
		REDSTONE_ORE => REDSTONE,
	];
	public static $enableExplosions = true;
	public $level; //Rays
	public $source;
	public $size;
	public $affectedBlocks = [];
	public $stepLen = 0.3;
	private $rays = 16;
	private $air;
	private $nullPlayer;

	public function __construct(Position $center, $size){
		$this->level = $center->level;
		$this->source = $center;
		$this->size = max($size, 0);
		$this->air = BlockAPI::getItem(AIR, 0, 1);
		$this->nullPlayer = new PlayerNull();
	}

	public function explode(){
		$radius = 2 * $this->size;
		$server = ServerAPI::request();
		if(!Explosion::$enableExplosions){ /*Disable Explosions*/
			foreach($server->api->entity->getRadius($this->source, $radius) as $entity){
							$impact = (1 - $this->source->distance($entity) / $radius) * 0.5; //pla>
							$damage = (int) (($impact * $impact + $impact) * 8 * $this->size + 1);
							$entity->harm($damage, "explosion");
					}
			return;
		}
		if($this->size < 0.1 or $server->api->dhandle("entity.explosion", [
				"level" => $this->level,
				"source" => $this->source,
				"size" => $this->size
			]) === false){
			return false;
		}
		$mRays = $this->rays - 1;
		for($i = 0; $i < $this->rays; ++$i){
			for($j = 0; $j < $this->rays; ++$j){
				for($k = 0; $k < $this->rays; ++$k){
					if($i == 0 or $i == $mRays or $j == 0 or $j == $mRays or $k == 0 or $k == $mRays){
						$vector = new Vector3($i / $mRays * 2 - 1, $j / $mRays * 2 - 1, $k / $mRays * 2 - 1); //($i / $mRays) * 2 - 1
						$vector = $vector->normalize()->multiply($this->stepLen);
						$pointer = clone $this->source;

						for($blastForce = $this->size * (mt_rand(700, 1300) / 1000); $blastForce > 0; $blastForce -= $this->stepLen * 0.75){
							$vBlock = $pointer->floor();
							$blockID = $this->level->level->getBlockID($vBlock->x, $vBlock->y, $vBlock->z);
							$blockMeta = $this->level->level->getBlockDamage($vBlock->x, $vBlock->y, $vBlock->z);
							if($blockID > 0){
								$block = BlockAPI::get($blockID, $blockMeta);
								$block->x = $vBlock->x;
								$block->y = $vBlock->y;
								$block->z = $vBlock->z;
								$block->level = $this->level;
								$blastForce -= ($block->getHardness() / 5 + 0.3) * $this->stepLen;
								if($blastForce > 0){
									$index = ($block->x << 15) + ($block->z << 7) + $block->y;
									if(!isset($this->affectedBlocks[$index])){
										$this->affectedBlocks[$index] = $block;
									}
								}
							}
							$pointer = $pointer->add($vector);
						}
					}
				}
			}
		}

		$send = [];
		$source = $this->source->floor();
		foreach($server->api->entity->getRadius($this->source, $radius) as $entity){
			$impact = (1 - $this->source->distance($entity) / $radius) * 0.5; //placeholder, 0.7 should be exposure
			$damage = (int) (($impact * $impact + $impact) * 8 * $this->size + 1);
			$entity->harm($damage, "explosion");
		}

		foreach($this->affectedBlocks as $block){
			if($block instanceof TNTBlock){
				$data = [
					"x" => $block->x + 0.5,
					"y" => $block->y + 0.5,
					"z" => $block->z + 0.5,
					"power" => 4,
					"fuse" => mt_rand(10, 30), //0.5 to 1.5 seconds
				];
				$e = $server->api->entity->add($this->level, ENTITY_OBJECT, OBJECT_PRIMEDTNT, $data);
				$server->api->entity->spawnToAll($e);
			}elseif(mt_rand(0, 10000) < ((1 / $this->size) * 10000)){
				$dropz = $block->getDrops($this->air, $this->nullPlayer);
				if(is_array($dropz)){
					foreach($dropz as $drop){
						$server->api->entity->drop(new Position($block->x + 0.5, $block->y, $block->z + 0.5, $this->level), BlockAPI::getItem($drop[0], $drop[1], $drop[2])); //id, meta, count
					}
				}
			}
			$this->level->setBlock($block, new AirBlock(), true);
			$send[] = $block->subtract($source);
		}
		$pk = new ExplodePacket;
		$pk->x = $this->source->x;
		$pk->y = $this->source->y;
		$pk->z = $this->source->z;
		$pk->radius = $this->size;
		$pk->records = $send;
		$server->api->player->broadcastPacket($this->level->players, $pk);
	}
}
