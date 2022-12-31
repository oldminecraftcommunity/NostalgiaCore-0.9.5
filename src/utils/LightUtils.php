<?php

class LightUtils{

	/*
	args: $source: <Block> instanceof LightingBlock, $block: Block
	*/
	public static function getLightValueFromNearbySource($source, $block){
		if($source === null || $block === null){
			return 0;
		}
		$distance = sqrt(LightUtils::sqr($source->x - $block->x) + LightUtils::sqr($source->y - $block->y) + LightUtils::sqr($source->z - $block->z)); /*Distance between 2 3d objects*/
		$result = floor($source->getMaxLightValue() - $distance); //i dont need something like 0.2192032434454...
		return $result <= 0 ? 0 : $result; //if result is smaller or equals 0 then return 0 else return result
	}

	/* Used only internally for calculating 2^(2) */
	private static function sqr($val){
		return pow($val, 2);
	}
}