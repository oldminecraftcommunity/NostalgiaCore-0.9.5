<?php

class PharUtils{
	
	public static function readMainConfig($content){
		$pluginData = [];
		$content = explode("\n", $content);
		foreach($content as $id => $line){
			if(!strpos($line, "=")){
				continue;
			}
			
			$line = explode("=", $line);
			$content[$line[0]] = $line[1];
		}
		
		$pluginData["name"] = trim($content["name"]);
		$pluginData["description"] = trim($content["description"]);
		$pluginData["version"] = trim($content["version"]);
		$pluginData["author"] = trim($content["author"]);
		$pluginData["mainFile"] = trim($content["mainFile"]);
		$pluginData["api"] = explode(",", trim($content["api"]));
		$pluginData["classLoader"] = trim($content["classLoader"]);
		$pluginData["CLClass"] = self::getNameSpaceClass($pluginData["classLoader"]);
		return $pluginData;
	}
	
	public static function getNameSpaceClass($content){
		return trim(substr(str_replace("/", "\\", $content), 0, -4));
	}
	
	
}