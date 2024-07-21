<?php

class LightUtils{
	/**
	 * @param LightingBlock $source
	 * @param Block $block
	 * @return number
	 */
	public static function getLightValueFromNearbySource($source, $block){
		if($source === null || $block === null){
			return 0;
		}
		$diffX = ($source->x - $block->x);
		$diffY = ($source->y - $block->y);
		$diffZ = ($source->z - $block->z);
		$distance = $diffX*$diffX + $diffY*$diffY + $diffZ*$diffZ;
		$result = floor($source->getMaxLightValue() - $distance);
		return $result <= 0 ? 0 : $result;
	}
}