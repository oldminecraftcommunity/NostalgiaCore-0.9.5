<?php

/**
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

class Item{
	public static $class = array(
	
		//armor
		LEATHER_CAP => "LeatherCapItem",
		LEATHER_TUNIC => "LeatherTunicItem",
		LEATHER_PANTS => "LeatherPantsItem",
		LEATHER_BOOTS => "LeatherBootsItem",
		CHAIN_HELMET => "ChainHelmetItem",
		CHAIN_CHESTPLATE => "ChainChestplateItem",
		CHAIN_LEGGINGS => "ChainLeggingsItem",
		CHAIN_BOOTS => "ChainBootsItem",
		IRON_HELMET => "IronHelmetItem",
		IRON_CHESTPLATE => "IronChestplateItem",
		IRON_LEGGINGS => "IronLeggingsItem",
		IRON_BOOTS => "IronBootsItem",
		DIAMOND_HELMET => "DiamondHelmetItem",
		DIAMOND_CHESTPLATE => "DiamondChestplateItem",
		DIAMOND_LEGGINGS => "DiamondLeggingsItem",
		DIAMOND_BOOTS => "DiamondBootsItem",
		GOLDEN_HELMET => "GoldenHelmetItem",
		GOLDEN_CHESTPLATE => "GoldenChestplateItem",
		GOLDEN_LEGGINGS => "GoldenLeggingsItem",
		GOLDEN_BOOTS => "GoldenBootsItem",
		
		//food
		APPLE => "AppleItem",
		MUSHROOM_STEW => "MushroomStewItem",
		BREAD => "BreadItem",
		RAW_PORKCHOP => "RawPorkchopItem",
		COOKED_PORKCHOP => "CookedPorkchopItem",
		CAKE => "CakeItem",
		MELON => "MelonItem",
		BEEF => "BeefItem",
		STEAK => "SteakItem",
		RAW_CHICKEN => "RawChickenItem",
		COOKED_CHICKEN => "CookedChickenItem",
		CARROT => "CarrotItem",
		POTATO => "PotatoItem",
		BAKED_POTATO => "BakedPotatoItem",
		PUMPKIN_PIE => "PumpkinPieItem",
		BEETROOT => "BeetrootItem",
		BEETROOT_SOUP => "BeetrootSoupItem",
	
		//generic
		ARROW => "ArrowItem",
		COAL => "CoalItem",
		DIAMOND => "DiamondItem",
		IRON_INGOT => "IronIngotItem",
		GOLD_INGOT => "GoldIngotItem",
		STICK => "StickItem",
		BOWL => "BowlItem",
		'STRING' => "StringItem",
		FEATHER => "FeatherItem",
		GUNPOWDER => "GunpowderItem",
		WHEAT_SEEDS => "WheatSeedsItem",
		WHEAT => "WheatItem",
		FLINT => "FlintItem",
		PAINTING => "PaintingItem",
		SIGN => "SignItem",
		WOODEN_DOOR => "WoodenDoorItem",
		BUCKET => "BucketItem",
		MINECART => "MinecartItem",
		SADDLE => "SaddleItem",
		IRON_DOOR => "IronDoorItem",
		REDSTONE => "RedstoneItem",
		SNOWBALL => "SnowballItem",
		LEATHER => "LeatherItem",
		BRICK => "BrickItem",
		CLAY => "ClayItem",
		SUGARCANE => "SugarCaneItem",
		PAPER => "PaperItem",
		BOOK => "BookItem",
		SLIMEBALL => "SlimeballItem",
		EGG => "EggItem",
		GLOWSTONE_DUST => "GlowstoneDustItem",
		DYE => "DyeItem",
		BONE => "BoneItem",
		SUGAR => "SugarItem",
		BED => "BedItem",
		PUMPKIN_SEEDS => "PumpkinSeedsItem",
		MELON_SEEDS => "MelonSeedsItem",
		SPAWN_EGG => "SpawnEggItem",
		NETHER_BRICK => "NetherBrickItem",
		QUARTZ => "QuartzItem",
		CAMERA => "CameraItem",
		BEETROOT_SEEDS => "BeetrootSeedsItem",
		
		//tool
		IRON_SHOVEL => "IronShovelItem",
		IRON_PICKAXE => "IronPickaxeItem",
		IRON_AXE => "IronAxeItem",
		FLINT_STEEL => "FlintSteelItem",
		BOW => "BowItem",
		IRON_SWORD => "IronSwordItem",
		WOODEN_SWORD => "WoodenSwordItem",
		WOODEN_SHOVEL => "WoodenShovelItem",
		WOODEN_PICKAXE => "WoodenPickaxeItem",
		WOODEN_AXE => "WoodenAxeItem",
		STONE_SWORD => "StoneSwordItem",
		STONE_SHOVEL => "StoneShovelItem",
		STONE_PICKAXE => "StonePickaxeItem",
		STONE_AXE => "StoneAxeItem",
		DIAMOND_SWORD => "DiamondSwordItem",
		DIAMOND_SHOVEL => "DiamondShovelItem",
		DIAMOND_PICKAXE => "DiamondPickaxeItem",
		DIAMOND_AXE => "DiamondAxeItem",
		GOLDEN_SWORD => "GoldenSwordItem",
		GOLDEN_SHOVEL => "GoldenShovelItem",
		GOLDEN_PICKAXE => "GoldenPickaxeItem",
		GOLDEN_AXE => "GoldenAxeItem",
		WOODEN_HOE => "WoodenHoeItem",
		STONE_HOE => "StoneHoeItem",
		IRON_HOE => "IronHoeItem",
		DIAMOND_HOE => "DiamondHoeItem",
		GOLDEN_HOE => "GoldenHoeItem",
		COMPASS => "CompassItem",
		CLOCK => "ClockItem",
		SHEARS => "ShearsItem",
		
	);
	protected $block;
	protected $id;
	protected $meta;
	public $count;
	protected $maxStackSize = 64;
	protected $durability = 0;
	protected $name;
	public $isActivable = false;
	
	public function __construct($id, $meta = 0, $count = 1, $name = "Unknown"){
		$this->id = (int) $id;
		$this->meta = (int) $meta;
		$this->count = (int) $count;
		$this->name = $name;
		if(!isset($this->block) and $this->id <= 0xff and isset(Block::$class[$this->id])){
			$this->block = BlockAPI::get($this->id, $this->meta);
			$this->name = $this->block->getName();
		}
		if($this->isTool() !== false){
			$this->maxStackSize = 1;
		}
	}
	
	final public function getName(){
		return $this->name;
	}
	
	final public function isPlaceable(){
		return (($this->block instanceof Block) and $this->block->isPlaceable === true);
	}
	
	final public function getBlock(){
		if($this->block instanceof Block){
			return $this->block;
		}else{
			return BlockAPI::get(AIR);
		}
	}
	
	final public function getID(){
		return $this->id;
	}
	
	final public function getMetadata(){
		return $this->meta;
	}	
	
	final public function getMaxStackSize(){
		return $this->maxStackSize;
	}
	
	final public function getFuelTime(){
		if(!isset(FuelData::$duration[$this->id])){
			return false;
		}
		if($this->id !== BUCKET or $this->meta === 10){
			return FuelData::$duration[$this->id];
		}
		return false;
	}
	
	final public function getSmeltItem(){
		if(!isset(SmeltingData::$product[$this->id])){
			return false;
		}
		
		if(isset(SmeltingData::$product[$this->id][0]) and !is_array(SmeltingData::$product[$this->id][0])){
			return BlockAPI::getItem(SmeltingData::$product[$this->id][0], SmeltingData::$product[$this->id][1]);
		}
		
		if(!isset(SmeltingData::$product[$this->id][$this->meta])){
			return false;
		}
		
		return BlockAPI::getItem(SmeltingData::$product[$this->id][$this->meta][0], SmeltingData::$product[$this->id][$this->meta][1]);
		
	}
	
	public function useOn($object, $force = false){
		if($this->isTool() or $force === true){
			if(($object instanceof Entity) and !$this->isSword()){
				$this->meta += 2;
			}else{
				$this->meta++;
			}
			return true;
		}elseif($this->isHoe()){
			if(($object instanceof Block) and ($object->getID() === GRASS or $object->getID() === DIRT)){
				$this->meta++;
			}
		}
		return false;
	}
	
	final public function isTool(){
		return ($this->id === FLINT_STEEL or $this->id === SHEARS or $this->isPickaxe() !== false or $this->isAxe() !== false or $this->isShovel() !== false or $this->isSword() !== false);
	}
	
	final public function getMaxDurability(){
		$isArmor = $this->isArmor();
		if($isArmor !== false){
			$armorDurability = [
				10 => 56,
				11 => 81,
				12 => 76,
				13 => 66,
				
				20 => 166,
				21 => 241,
				22 => 226,
				23 => 196,
				
				30 => 166,
				31 => 241,
				32 => 226,
				33 => 196,
				
				40 => 364,
				41 => 529,
				42 => 496,
				43 => 430,
				
				50 => 78,
				51 => 113,
				52 => 106,
				53 => 92,
			];
			return $armorDurability[$isArmor];
		}
		if(!$this->isTool() and $this->isHoe() === false and $this->id !== BOW){
			return false;
		}
		
		$levels = array(
			2 => 40, //GOLD
			1 => 59, //WOODEN
			3 => 131, //STONE
			4 => 250, //IRON
			5 => 1561, //DIAMOND(called EMERALD in disassembled code)
			FLINT_STEEL => 65,
			SHEARS => 239,
			BOW => 385,
		);

		if(($type = $this->isPickaxe()) === false){			
			if(($type = $this->isAxe()) === false){			
				if(($type = $this->isSword()) === false){				
					if(($type = $this->isShovel()) === false){					
						if(($type = $this->isHoe()) === false){
							$type = $this->id;
						}
					}	
				}
			}
		}
		return $levels[$type];
	}
	final public function isArmor(){
		switch($this->id){
			case LEATHER_CAP:
				return 10;
			case LEATHER_TUNIC:
				return 11;
			case LEATHER_PANTS:
				return 12;
			case LEATHER_BOOTS:
				return 13;
				
			case CHAIN_HELMET:
				return 20;
			case CHAIN_CHESTPLATE:
				return 21;
			case CHAIN_LEGGINGS:
				return 22;
			case CHAIN_BOOTS:
				return 23;
				
			case IRON_HELMET:
				return 30;
			case IRON_CHESTPLATE:
				return 31;
			case IRON_LEGGINGS:
				return 32;
			case IRON_BOOTS:
				return 33;	
				
			case DIAMOND_HELMET:
				return 40;
			case DIAMOND_CHESTPLATE:
				return 41;
			case DIAMOND_LEGGINGS:
				return 42;
			case DIAMOND_BOOTS:
				return 43;
				
			case GOLD_HELMET:
				return 50;
			case GOLD_CHESTPLATE:
				return 51;
			case GOLD_LEGGINGS:
				return 52;
			case GOLD_BOOTS:
				return 53;
			default:
				return false;
		}
		
	}
	final public function isPickaxe(){ //Returns false or level of the pickaxe
		switch($this->id){
			case IRON_PICKAXE:
				return 4;
			case WOODEN_PICKAXE:
				return 1;
			case STONE_PICKAXE:
				return 3;
			case DIAMOND_PICKAXE:
				return 5;
			case GOLDEN_PICKAXE:
				return 2;
			default:
				return false;
		}
	}
	
	final public function isAxe(){
		switch($this->id){
			case IRON_AXE:
				return 4;
			case WOODEN_AXE:
				return 1;
			case STONE_AXE:
				return 3;
			case DIAMOND_AXE:
				return 5;
			case GOLDEN_AXE:
				return 2;
			default:
				return false;
		}
	}

	final public function isSword(){
		switch($this->id){
			case IRON_SWORD:
				return 4;
			case WOODEN_SWORD:
				return 1;
			case STONE_SWORD:
				return 3;
			case DIAMOND_SWORD:
				return 5;
			case GOLDEN_SWORD:
				return 2;
			default:
				return false;
		}
	}
	
	final public function isShovel(){
		switch($this->id){
			case IRON_SHOVEL:
				return 4;
			case WOODEN_SHOVEL:
				return 1;
			case STONE_SHOVEL:
				return 3;
			case DIAMOND_SHOVEL:
				return 5;
			case GOLDEN_SHOVEL:
				return 2;
			default:
				return false;
		}
	}
	
	public function isHoe(){
		switch($this->id){
			case IRON_HOE:
			case WOODEN_HOE:
			case STONE_HOE:
			case DIAMOND_HOE:
			case GOLDEN_HOE:
				return true;
			default:
				return false;
		}
	}

	public function isShears(){
		return ($this->id === SHEARS);
	}
	
	final public function __toString(){
		return "Item ". $this->name ." (".$this->id.":".$this->meta.")";
	}
	
	public function getDestroySpeed(Block $block, Player $player){
		return 1;
	}
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		return false;
	}
	
}
