<?php

class CameraItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(CAMERA, 0, $count, "item.camera.name<");
	}

}