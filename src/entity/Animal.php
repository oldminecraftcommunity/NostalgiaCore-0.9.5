<?php
/*
TODO:
move methods
*/
abstract class Animal extends Creature implements Ageable, Breedable{
	
    public $parent;
    public $inLove; //do NOT add it into metadata, it doesnt send it to player
	public function isBaby(){
		if(!isset($this->data["IsBaby"])){
			$this->data["IsBaby"] = false;
		}
		return $this->data["IsBaby"];
	}
	
	public function spawnChild(){
	    //TODO
	    //$c->parent = $this->eid;
	}
	public function getMetadata(){
		$d = parent::getMetadata();
		if(!isset($this->data["IsBaby"])){
			$this->data["IsBaby"] = 0;
		}
		$d[14]["value"] = $this->isBaby();
		return $d;
	}
	
	public function createSaveData(){
	    $data = parent::createSaveData();
	    $data["IsBaby"] = $this->isBaby();
	    return $data;
	    
	}
	
	public function isInLove(){
	    return $this->inLove > 0;
	}
	
	public function interactWith(Entity $e, $action){
	    if($e->isPlayer() && $action === InteractPacket::ACTION_HOLD){
	        $slot = $e->player->getHeldItem();
	        if($this->isFood($slot->getID())){
	            $e->player->removeItem($slot->getID(), $slot->getMetadata(), 1);
	            $this->inLove = 600; //600 ticks, original mehod from mcpe
	            return true;
	        }
	    }
	    parent::interactWith($e, $action);
	}
	
	public function counterUpdate(){
	    parent::counterUpdate();
	    if($this->isInLove()){
	        --$this->inLove;
	    }
	}
	
	public function environmentUpdate(){
		if($this->server->api->getProperty("spawn-animals") !== true){
			$this->close();
			return false;
		}
		return parent::environmentUpdate();
	}
	
	public function getDrops(){
		if($this->isBaby()){
			return array(
				array(AIR, 0, 0),
			);
		}
	}
}