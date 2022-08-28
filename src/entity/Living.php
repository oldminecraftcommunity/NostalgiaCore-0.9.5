<?php
abstract class Living extends Entity implements Damageable, Pathfindable{
	public function getPathfinder(){ //Placeholder
		return $this->pathFinder;
	}
}