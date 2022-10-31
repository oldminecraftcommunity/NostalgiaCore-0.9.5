<?php

class Sheep extends Animal{
    public $color;
	const TYPE = MOB_SHEEP;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 8, "generic");
		$this->setName("Sheep");
		$this->data["Color"] = isset($this->data["Color"]) ? $this->data["Color"] : $this->sheepColor();
		$this->setSize($this->isBaby() ? 0.45 : 0.9, $this->isBaby() ? 0.675 : 1.3);
		$this->setSpeed(0.25);
		$this->update();
	}
	
	public function setSheared($v = null){
	    $this->data["Sheared"] = $v === null ? !$this->isSheared() : $v;
	    $this->updateMetadata();
	}
	
	public function isSheared(){
	    return $this->data["Sheared"];
	}
	
	public function getColor(){
	    return $this->data["Color"] & 16; //color === 16 -> color = 0, color === 17 -> color = 1 ...
	}
	
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : [
			[WOOL, $this->getColor() & 0x0F, 1],
		];
	}
	
	public function isFood($id){
		return $id === WHEAT;
	}
	
	public function interactWith(Entity $e, $action){
	    if($e->isPlayer() && $action === InteractPacket::ACTION_HOLD){
	        $slot = $e->player->getHeldItem();
	        if($slot->getID() === SHEARS){
	            if(!$this->isSheared()){
	                $this->setSheared(1);
	                $this->server->api->entity->drop($this, BlockAPI::getItem(WOOL, $this->getColor(), mt_rand(1, 3)));
	                if($slot->getMetadata() >= $slot->getMaxDurability()){
	                    $this->removeItem($slot->getID(), $slot->getMetadata(), $slot->count, true);
	                }
	            }
	            return true;
	        }
	    }
	    return parent::interactWith($e, $action);
	}
	
	public function getMetadata(){
		$d = parent::getMetadata();
		if(!isset($this->data["Sheared"])){
			$this->data["Sheared"] = 0;
		}
		$d[16]["value"] = ($this->data["Sheared"] << 4) | ($this->getColor() & 0x0F);
		return $d;
	}
	
	public function sheepColor(){ //a method from 0.8.1
		$c = mt_rand(0,100);
		if($c <= 4){
		    return 0xF; //white
		}
		if($c <= 9){
		    return 0x7;
		}
		if($c <= 14){
		    return 0x8;
		}
		if($c <= 17){
		    return 0xC;
		}
		if(mt_rand(0, 500)){
		    return 0x0;
		}
		return 0x0;
	}
}