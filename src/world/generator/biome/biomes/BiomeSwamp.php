<?php

class BiomeSwamp extends BiomeWithGrass
{
	public function __construct($id, $name){ //TODO more beautiful?
		parent::__construct($id, $name);
		/*$flower = new Flower();
		$flower->setBaseAmount(8);
		$flower->addType([Block::RED_FLOWER, FlowerBlock::TYPE_BLUE_ORCHID]);

		$this->addPopulator($flower);

		$lilypad = new LilyPad();
		$lilypad->setBaseAmount(4);
		$this->addPopulator($lilypad);
		 */
		$this->setMinMax(62, 63);
	}
}

