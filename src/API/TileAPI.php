<?php

class TileAPI{

	private $server;
	private $tiles;
	private $tCnt = 1;

	function __construct(){
		$this->tiles = [];
		$this->server = ServerAPI::request();
	}
	public function getXYZ(Level $level, $x, $y, $z){
		$tile = $this->server->query("SELECT * FROM tiles WHERE level = '{$level->getName()}' AND x = $x AND y = $y AND z = $z;", true);
		if($tile !== false and $tile !== true and ($tile = $this->getByID($tile["ID"])) !== false){
			return $tile;
		}
		return false;
	}
	
	public function invalidateAll(Level $level, $x, $y, $z){
		$x = (int) $x;
		$y = (int) $y;
		$z = (int) $z;
		$tile = $this->server->query("SELECT id FROM tiles WHERE level = '{$level->getName()}' AND x = $x AND y = $y AND z = $z;", false);
		$invcnt = 0;
		if($tile instanceof SQLite3Result){
			while(($t = $tile->fetchArray(SQLITE3_ASSOC)) !== false){
				$tl = $this->getByID($t["ID"]);
				if($tl instanceof Tile){
					++$invcnt;
					$tl->close();
				}
				
				if($invcnt > 1){
					ConsoleAPI::warn("{$level->getName()}: ($x $y $z) has more than 1 tile entity! Invalidated ID {$t["ID"]} (Total invaliated: $invcnt)");
				}
			}
		}
	}
	
	public function get(Position $pos){
		$tile = $this->server->query("SELECT * FROM tiles WHERE level = '" . $pos->level->getName() . "' AND x = {$pos->x} AND y = {$pos->y} AND z = {$pos->z};", true);
		if($tile !== false and $tile !== true and ($tile = $this->getByID($tile["ID"])) !== false){
			return $tile;
		}
		return false;
	}

	public function getByID($id){
		if($id instanceof Tile){
			return $id;
		}elseif(isset($this->tiles[$id])){
			return $this->tiles[$id];
		}
		return false;
	}

	public function init(){

	}

	public function addSign(Level $level, $x, $y, $z, $lines = ["", "", "", ""]){
		return $this->add($level, TILE_SIGN, $x, $y, $z, $data = [
			"id" => "Sign",
			"x" => $x,
			"y" => $y,
			"z" => $z,
			"Text1" => $lines[0],
			"Text2" => $lines[1],
			"Text3" => $lines[2],
			"Text4" => $lines[3],
		]);
	}

	public function add(Level $level, $class, $x, $y, $z, $data = []){
		$id = $this->tCnt++;
		$this->tiles[$id] = new Tile($level, $id, $class, $x, $y, $z, $data);
		$this->spawnToAll($this->tiles[$id]);
		return $this->tiles[$id];
	}

	public function spawnToAll(Tile $t){
		foreach($this->server->api->player->getAll($t->level) as $player){
			if($player->eid !== false){
				$t->spawn($player);
			}
		}
	}

	public function spawnAll(Player $player){
		foreach($this->getAll($player->level) as $t){
			$t->spawn($player);
		}
	}

	public function getAll($level = null){
		if($level instanceof Level){
			$tiles = [];
			$l = $this->server->query("SELECT ID FROM tiles WHERE level = '" . $level->getName() . "';");
			if($l !== false and $l !== true){
				while(($t = $l->fetchArray(SQLITE3_ASSOC)) !== false){
					$t = $this->getByID($t["ID"]);
					if($t instanceof Tile){
						$tiles[$t->id] = $t;
					}
				}
			}
			return $tiles;
		}
		return $this->tiles;
	}

	public function remove($id){
		if(isset($this->tiles[$id])){
			$t = $this->tiles[$id];
			$this->tiles[$id] = null;
			unset($this->tiles[$id]);
			$t->closed = true;
			$t->close();
			$this->server->query("DELETE FROM tiles WHERE ID = " . $id . ";");
			$this->server->api->dhandle("tile.remove", $t);
			$t = null;
			unset($t);
		}
	}
}