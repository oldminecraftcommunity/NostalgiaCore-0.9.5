<?php


class Deprecation{

	public static $events = [
		"server.tick" => "ServerAPI::schedule()",
		"server.time" => "time.change",
		"world.block.change" => "block.change",
		"block.drop" => "item.drop",
		"api.op.check" => "op.check",
		"api.player.offline.get" => "player.offline.get",
		"api.player.offline.save" => "player.offline.save",
	];
}