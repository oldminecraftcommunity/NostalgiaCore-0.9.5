<?php

abstract class Biome{
	protected $id, $topBlocks, $fillerBlock, $name, $minY, $maxY;
	public function __construct($id, $name){
		$this->name = $name;
		$this->id = $id;
	}
	
	public function setTopBlocks($id){
		$this->topBlocks = $id;
	}
	
	public function getID(){
		return $this->id;
	}
	
	public function setMinMax($min, $max){
		$this->minY = $min;
		$this->maxY = $max;
	}
	
	public function getMin(){
		return $this->minY;
	}
	
	public function getTopBlocks(){
		return $this->topBlocks;
	}
	
	public function getMax(){
		return $this->maxY;
	}
	
	public function setFillerBlock($id){
		$this->fillerBlock = $id;
	}
	
	public function getBiomeAt($x, $z){
		self::$biomeLookup[$x + $z * 64];
	}
	
	public function __toString(){
		return $this->name;
	}
	
	public static function init(){
		BiomeSelector::registerBiome(new BiomeExtremeHills(BIOME_EXTREME_HILLS, "Extreme Hills"));
		BiomeSelector::registerBiome(new BiomePlains(BIOME_PLAINS, "Plains"));
		BiomeSelector::registerBiome(new BiomeExtremeHillsEdge(BIOME_EXTREME_HILLS_EDGE, "Extreme Hills Edge"));
		BiomeSelector::registerBiome(new BiomeRiver(BIOME_RIVER, "River"));
		BiomeSelector::registerBiome(new BiomeOcean(BIOME_OCEAN, "Ocean"));
		BiomeSelector::registerBiome(new BiomeSwamp(BIOME_SWAMP, "Swamp"));
		BiomeSelector::registerBiome(new BiomeIcePlains(BIOME_ICE_PLAINS, "Ice Plains"));
		BiomeSelector::registerBiome(new BiomeDesert(BIOME_DESERT, "Desert"));
		BiomeSelector::registerBiome(new BiomeTaiga(BIOME_TAIGA, "Taiga"));
		BiomeSelector::registerBiome(new BiomeForest(BIOME_FOREST, "Forest"));
		BiomeSelector::registerBiome(new BiomeForest(BIOME_BIRCH_FOREST, "Birch Forest"));
	}

	private static $initialized = false;
	public static $temperature, $rainfall;
	public static $biomes = [];
}
