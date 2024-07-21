<?php

class Biome
{
	/**
	 * @var Biome[]
	 */
	public static $biomes = [];
	/**
	 * @var Biome $rainForest
	 * @var Biome $swampLand
	 * @var Biome $seasonalForest
	 * @var Biome $forest
	 * @var Biome $savanna
	 * @var Biome $shrubland
	 * @var Biome $taiga
	 * @var Biome $desert
	 * @var Biome $plains
	 * @var Biome $iceDesert
	 * @var Biome $tundra
	 */
	public static $rainForest, $swampLand, $seasonalForest, $forest, $savanna, $shrubland, $taiga, $desert, $plains, $iceDesert, $tundra;
	
	
	public static function init(){
		Biome::$rainForest = new Biome("Rainforest");
		Biome::$swampLand = new Biome("Swampland");
		Biome::$seasonalForest = new Biome("Seasonal Forest");
		Biome::$forest = new ForestBiome("Forest");
		Biome::$savanna = new Biome("Savanna");
		Biome::$shrubland = new Biome("Shrubland");
		Biome::$taiga = new TaigaBiome("Taiga");
		Biome::$desert = new FlatBiome("Desert");
		Biome::$plains = new FlatBiome("Plains");
		Biome::$iceDesert = new FlatBiome("Ice Desert"); //unsed
		Biome::$tundra = new Biome("Tundra");
		Biome::recalc();
	}
	public static function recalc(){
		for($i = 0; $i < 64; ++$i){
			for($j = 0; $j < 64; ++$j){
				Biome::$biomes[$i + ($j * 64)] = Biome::__getBiome(((float) $i / 63), ((float) $j / 63));
			}
		}
		Biome::$desert->topBlock = Biome::$desert->fillerBlock = SAND;
		Biome::$iceDesert->topBlock = Biome::$iceDesert->fillerBlock = SAND;
	}
	public static function getBiome($temp, $rain){
		$i = ((int) ($temp * 63));
		$j = ((int) ($rain * 63));
		return Biome::$biomes[$i + $j*64];
	}
	public static function __getBiome($temp, $rain){
		$rain *= $temp;
		if($temp < 0.1) return Biome::$tundra;
		
		if($rain < 0.2){
			if($temp < 0.5) return Biome::$tundra;
			if($temp < 0.95) return Biome::$savanna;
			else return Biome::$desert;
		}
		
		if($rain > 0.5 && $temp < 0.7) return Biome::$swampLand;
		if($temp < 0.5) return Biome::$taiga;
		
		if($temp < 0.97){
			if($rain < 0.45) return Biome::$shrubland;
			else return Biome::$forest;
		}
		
		if($rain < 0.45) return Biome::$plains;
		if($rain < 0.9) return Biome::$seasonalForest;
		return Biome::$rainForest;
	}
	public function __construct($name){
		$this->name = $name;
	}
	
	public function getTreeFeature(MTRandom $rand){
		$rand->nextInt(); //it is necessary
		return Feature::$TREE;
	}
	
	public $name;
	public $topBlock = GRASS, $fillerBlock = DIRT;
}

