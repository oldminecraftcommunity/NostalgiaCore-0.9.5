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
		
		$pluginData["name"] = $content["name"];
		$pluginData["description"] = $content["description"];
		$pluginData["version"] = $content["version"];
		$pluginData["author"] = $content["author"];
		$pluginData["mainFile"] = $content["mainFile"];
		$pluginData["api"] = $content["api"];
		$pluginData["classLoader"] = $content["classLoader"];
		$pluginData["CLClass"] = self::getNameSpaceClass($pluginData["classLoader"]);
		return $pluginData;
	}
	
	public static function getNameSpaceClass($content){
		return substr(str_replace("/", "\\", $content), 0, -4);
	}
	
	
}