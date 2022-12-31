<?php

class PaintingItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(PAINTING, 0, $count, "Painting");
		$this->isActivable = true;
	}
	private static $motives = array(
		// Motive Width Height
		array("Wasteland", 1, 1),
		array("Wanderer", 1, 2),
		array("Graham", 1, 2),
		array("Pool", 2, 1),
		array("Courbet", 2, 1),
		array("Sunset", 2, 1),
		array("Sea", 2, 1),
		array("Creebet", 2, 1),
		array("Match", 2, 2),
		array("Bust", 2, 2),
		array("Stage", 2, 2),
		array("Void", 2, 2),
		array("SkullAndRoses", 2, 2),
		//array("Wither", 2, 2),
		array("Fighters", 4, 2),
		array("Skeleton", 4, 3),
		array("DonkeyKong", 4, 3),
		array("Pointer", 4, 4),
		array("Pigscene", 4, 4),
		array("Flaming Skull", 4, 4),
	);
	private static $direction = array(2, 0, 1, 3);
	private static $right = array(4, 5, 3, 2);
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($target->isTransparent === false and $face > 1 and $block->isSolid === false){
			$server = ServerAPI::request();
			$faces = array(
				2 => 1,
				3 => 3,
				4 => 0,
				5 => 2,
			
			);
			
			$validMotives = array(
				array("Kebab", 1, 1),
				array("Aztec", 1, 1),
				array("Alban", 1, 1),
				array("Aztec2", 1, 1),
				array("Bomb", 1, 1),
				array("Plant", 1, 1),		
			);
			foreach(PaintingItem::$motives as $motive){
				$valid = true;
				for($x = 0; $x <= $motive[1]; $x++){
					for($y = 0; $y <= $motive[2]; $y++){
						if ($target->getSide(PaintingItem::$right[$face - 2], $x)->isTransparent || $target->getSide(1, $y)->isTransparent
							|| $block->getSide(PaintingItem::$right[$face - 2], $x)->isSolid || $block->getSide(1, $y)->isSolid) {
							$valid = false;
							break;
						}
					}
					if(!$valid){
						break;
					}
				}
				if ($valid) {
					$validMotives[] = $motive;
				}
			}
			$motive = $validMotives[array_rand($validMotives)];
			$data = array(
				"x" => $target->x,
				"y" => $target->y,
				"z" => $target->z,
				"yaw" => $faces[$face] * 90,
				"Motive" => $motive[0],
			);
			$e = $server->api->entity->add($level, ENTITY_OBJECT, OBJECT_PAINTING, $data);
			$server->api->entity->spawnToAll($e);
			if(($player->gamemode & 0x01) === 0x00){
				$player->removeItem($this->getID(), $this->getMetadata(), 1, false);
			}
			return true;
		}
		return false;
	}

}