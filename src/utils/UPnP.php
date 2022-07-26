<?php

function UPnP_PortForward($port){
	if(Utils::$online === false){
		return false;
	}
	if(Utils::getOS() != "win" or !class_exists("COM")){
		return false;
	}
	$port = (int) $port;
	$myLocalIP = gethostbyname(trim(`hostname`));
	try{
		$com = new COM("HNetCfg.NATUPnP");
		if($com === false or !is_object($com->StaticPortMappingCollection)){
			return false;
		}
		$com->StaticPortMappingCollection->Add($port, "UDP", $port, $myLocalIP, true, "NostalgiaCore");
	}catch(Exception $e){
		return false;
	}
	return true;
}

function UPnP_RemovePortForward($port){
	if(Utils::$online === false){
		return false;
	}
	if(Utils::getOS() != "win" or !class_exists("COM")){
		return false;
	}
	$port = (int) $port;
	try{
		$com = new COM("HNetCfg.NATUPnP") or false;
		if($com === false or !is_object($com->StaticPortMappingCollection)){
			return false;
		}
		$com->StaticPortMappingCollection->Remove($port, "UDP");
	}catch(Exception $e){
		return false;
	}
	return true;
}