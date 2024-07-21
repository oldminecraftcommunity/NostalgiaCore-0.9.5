<?php
class ThrownSnowball extends Projectile{
	const TYPE = OBJECT_SNOWBALL;
	public function onHit(MovingObjectPosition $hitResult){
		if($hitResult->typeOfHit == 1){
			$hitResult->entityHit->harm(0, $this->eid);
		}
		
		$this->close();
	}
}