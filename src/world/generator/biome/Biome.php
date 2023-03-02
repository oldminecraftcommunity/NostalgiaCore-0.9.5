<?php

abstract class Biome{
	protected $topBlock, $fillerBlock;
	public function __construct($id, $name){
		$this->name = $name;
		self::$biomes[$id] = $this;
	}
	
	public function setTopBlock($id){
		$this->topBlock = $id;
		return $this;
	}
	
	public function setFillerBlock($id){
		$this->fillerBlock = $id;
		return $this;
	}
	
	public function getBiomeAt($x, $z){
		self::$biomeLookup[$x + $z * 64];
	}

	
    public static function init(){
        //register biomes
    }
    
    public static $temperature, $rainfall;
    private static $biomeLookup = [];
    public static $biomes = [];
}