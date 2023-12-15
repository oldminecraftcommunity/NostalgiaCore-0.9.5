<?php

class LightUtils{
	public static function getLightValueFromNearbySource($source, $block){
		if($source === null || $block === null){
			return 0;
		}
		$distance = sqrt(($source->x - $block->x)*($source->x - $block->x) + ($source->y - $block->y)*($source->y - $block->y) + ($source->z - $block->z)*($source->z - $block->z));
		$result = floor($source->getMaxLightValue() - $distance);
		return $result < 0 ? 0 : $result;
	}
}