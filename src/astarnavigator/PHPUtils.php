<?php

class PHPUtils
{
	public static function removeElementFromArray(&$arr, $element, $reindex = true){
		if (($key = array_search($element, $arr)) !== false) {
			unset($arr[$key]);
			if($reindex) $arr = array_values($arr);
		}
	}
}

