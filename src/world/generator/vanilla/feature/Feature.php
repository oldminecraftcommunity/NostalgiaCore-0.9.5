<?php

abstract class Feature
{
	public static $TREE, $BIRCH_TREE, $PINE_TREE, $SPRUCE_TREE;
	public static $FLOWER_RED, $FLOWER_YELLOW, $MUSHROOM_BROWN, $MUSHROOM_RED;
	public static function init(){
		Feature::$TREE = new TreeFeature();	
		Feature::$BIRCH_TREE = new BirchFeature();
		Feature::$PINE_TREE = new PineFeature();
		Feature::$SPRUCE_TREE = new SpruceFeature();
		Feature::$FLOWER_RED = new FlowerFeature(ROSE);
		Feature::$FLOWER_YELLOW = new FlowerFeature(DANDELION);
		Feature::$MUSHROOM_BROWN = new FlowerFeature(BROWN_MUSHROOM);
		Feature::$MUSHROOM_RED = new FlowerFeature(RED_MUSHROOM);
		
	}
	public function place(Level $level, MTRandom $rand, $x, $y, $z){ //TODO pass VanillaGenerator instance and update heightmap on ceratin block placement
		
	}
}

