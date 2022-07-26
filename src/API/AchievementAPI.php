<?php

class AchievementAPI{

	public static $achievements = [
		/*"openInventory" => array(
			"name" => "Taking Inventory",
			"requires" => array(),
		),*/
		"mineWood" => [
			"name" => "Getting Wood",
			"requires" => [
				//"openInventory",
			],
		],
		"buildWorkBench" => [
			"name" => "Benchmarking",
			"requires" => [
				"mineWood",
			],
		],
		"buildPickaxe" => [
			"name" => "Time to Mine!",
			"requires" => [
				"buildWorkBench",
			],
		],
		"buildFurnace" => [
			"name" => "Hot Topic",
			"requires" => [
				"buildPickaxe",
			],
		],
		"acquireIron" => [
			"name" => "Acquire hardware",
			"requires" => [
				"buildFurnace",
			],
		],
		"buildHoe" => [
			"name" => "Time to Farm!",
			"requires" => [
				"buildWorkBench",
			],
		],
		"makeBread" => [
			"name" => "Bake Bread",
			"requires" => [
				"buildHoe",
			],
		],
		"bakeCake" => [
			"name" => "The Lie",
			"requires" => [
				"buildHoe",
			],
		],
		"buildBetterPickaxe" => [
			"name" => "Getting an Upgrade",
			"requires" => [
				"buildPickaxe",
			],
		],
		"buildSword" => [
			"name" => "Time to Strike!",
			"requires" => [
				"buildWorkBench",
			],
		],
		"diamonds" => [
			"name" => "DIAMONDS!",
			"requires" => [
				"acquireIron",
			],
		],
		"leather" => [
			"name" => "Cow Tipper",
			"requires" => [
				"buildSword",
			],
		],

	];

	function __construct(){
	}

	public static function addAchievement($achievementId, $achievementName, array $requires = []){
		if(!isset(self::$achievements[$achievementId])){
			self::$achievements[$achievementId] = [
				"name" => $achievementName,
				"requires" => $requires,
			];
			return true;
		}
		return false;
	}

	public static function grantAchievement(Player $player, $achievementId){
		if(isset(self::$achievements[$achievementId]) and !self::hasAchievement($player, $achievementId)){
			foreach(self::$achievements[$achievementId]["requires"] as $requerimentId){
				if(!self::hasAchievement($player, $requerimentId)){
					return false;
				}
			}
			if(ServerAPI::request()->api->dhandle("achievement.grant", ["player" => $player, "achievementId" => $achievementId]) !== false){
				$player->achievements[$achievementId] = true;
				self::broadcastAchievement($player, $achievementId);
				return true;
			}else{
				return false;
			}
		}
		return false;
	}

	public static function hasAchievement(Player $player, $achievementId){
		if(!isset(self::$achievements[$achievementId]) or !isset($player->achievements)){
			$player->achievements = [];
			return false;
		}

		if(!isset($player->achievements[$achievementId]) or $player->achievements[$achievementId] == false){
			return false;
		}
		return true;
	}

	public static function broadcastAchievement(Player $player, $achievementId){
		if(isset(self::$achievements[$achievementId])){
			$result = ServerAPI::request()->api->dhandle("achievement.broadcast", ["player" => $player, "achievementId" => $achievementId]);
			if($result !== false and $result !== true){
				if(ServerAPI::request()->api->getProperty("announce-player-achievements") == true){
					ServerAPI::request()->api->chat->broadcast($player->username . " has just earned the achievement [" . self::$achievements[$achievementId]["name"] . "]");
				}else{
					$player->sendChat("You have just earned the achievement [" . self::$achievements[$achievementId]["name"] . "]");
				}
			}
			return true;
		}
		return false;
	}

	public static function removeAchievement(Player $player, $achievementId){
		if(self::hasAchievement($player, $achievementId)){
			$player->achievements[$achievementId] = false;
		}
	}

	public function init(){
	}
}
