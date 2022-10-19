<?php
class Pig extends Animal{
	const TYPE = MOB_PIG;
	public $pathFinder, $pathFound, $path, $server;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
	    $this->pathFinder = new AStar($this); //make it before everything else as entity class constructor sends update
	    $this->pathFound = false;
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:10, "generic");
		$this->server = ServerAPI::request();
		$this->setSize($this->isBaby() ? 0.45 : 0.9, $this->isBaby() ? 0.45 : 0.9);
		$this->setName('Pig');
		$this->update();
	}
	public function isFood($id){
		return $id === POTATO || $id === CARROT || $id === BEETROOT;
	}
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : 
		array(
			array(($this->fire > 0 ? COOKED_PORKCHOP:RAW_PORKCHOP), 0, mt_rand(0,2)),
		);
	}
	
	public function update(){
	    if($this->pathFound && $this->path !== false and count($this->path) > 0){
	        
	    }else{
    	    //$start = new MinecraftNode(round($this->x), round($this->y), round($this->z));
    	    //$stop = $start->add(5,0,5);
    	    //$this->path = $this->pathFinder->findPath($start, $stop); //allows diagonals, path should be ~5 blocks
    	    //var_dump($this->path);
    	    $this->pathFound = true;
	    }
	    
	    
	    
	    parent::update();
	}
}
