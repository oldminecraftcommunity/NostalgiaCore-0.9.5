<?php
class ThrownEgg extends Projectile{
	const TYPE = OBJECT_EGG;
	
	public function onHit(MovingObjectPosition $hitResult){
		if($hitResult->typeOfHit == 1){
			$hitResult->entityHit->harm(0, $this->eid);
		}
		
		$rand = mt_rand(0, 7);
		if($rand == 0){
			$count = mt_rand(0, 31) == 0 ? 4 : 1;
			$data = [
				"x" => $this->x,
				"y" => $this->y,
				"z" => $this->z, 
				"yaw" => $this->yaw,
				"pitch" => 0,
				"IsBaby" => true
			];
			for($i = 0; $i < $count; ++$i){
				$chicken = $this->server->api->entity->add($this->level, ENTITY_MOB, MOB_CHICKEN, $data);
				
				$this->server->api->entity->spawnToAll($chicken);
			}
		}
		
		$this->close();
	}
	
	
}