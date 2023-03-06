<?php

class OakTreeStructure extends Structure{// implements TreeStructure{
	public $width = 5;
    public $length = 5;
	public $name = "Oak Tree";
	protected $structure = [
	];
	protected $map = [
		"W" => WOOD,
		//" " => 0,
		"D" => DIRT,
        "L" => LEAVES,
        "V" => [VINES, 2]
	];
    protected $dead = false;

    protected function getType(){
        if(mt_rand(0, 1)){
            return 0; //normal oak
        }
        //return 1; //fallen oak
        //return 2; //fancy oak
        return 3; //balloon oak
        //return 4; //swamp oak
    }
    
    protected function makeFallen(){

    }

    protected function makeDead(){
        if(mt_rand(0, 1)){
            $this->dead = true;
        }
    }

    protected function createLog(){
        $this->trunk = mt_rand(3, 5);
        $layers = [];
        for($i = 0; $i < $this->trunk - 2; $i++){
            if($this->dead){
                $layers[$i] = [
                    "",
                    "  V  ",
                    " VWV ",
                    "  V  ",
                ];
            }
            else{
                $layers[$i] = [
                    "",
                    "",
                    "  W  ",
                ];
            }
        }
        $this->structure = $layers;
    }

    protected function createLeaves(){
        $type = $this->getType();
        $layers = [];
        if($type == 0){
            $layers[$this->trunk - 2] = [
                "0LLL0",
                "LLLLL",
                "LLWLL",
                "LLLLL",
                "0LLL0",
            ];
            $layers[$this->trunk - 1] = [
                "0LLL0",
                "LLLLL",
                "LLWLL",
                "LLLLL",
                "0LLL0",
            ];
            $layers[$this->trunk] = [
                "",
                " 0L0 ",
                " LWL ",
                " 0L0 ",
            ];
            $layers[$this->trunk + 1] = [
                "",
                "  L  ",
                " LLL ",
                "  L  ",
            ];
        }
        elseif($type == 3){
            $layers[$this->trunk == 3 ? $this->trunk - 2 : $this->trunk - 3] = [
                "",
                "  L  ",
                " LWL ",
                "  L  ",
            ];
            if($this->trunk != 3){
                $layers[$this->trunk - 2] = [
                    " LLL ",
                    "LLLLL",
                    "LLWLL",
                    "LLLLL",
                    " LLL ",
                ];
            }
            $layers[$this->trunk - 1] = [
                " LLL ",
                "LLLLL",
                "LLWLL",
                "LLLLL",
                " LLL ",
            ];
            $layers[$this->trunk] = [
                " LLL ",
                "LLLLL",
                "LLWLL",
                "LLLLL",
                " LLL ",
            ];
            $layers[$this->trunk + 1] = [
                "",
                "  L  ",
                " LLL ",
                "  L  ",
            ];
        }

        foreach($layers as $layerID => $arrays){
            foreach($arrays as $lineID => $str){
                $line = str_split($str);
                for($i = 0; $i < count($line); $i++){
                    if(is_numeric($line[$i]) and Utils::chance(75)){
                        $line[$i] = " ";
                    }
                    elseif(is_numeric($line[$i])){
                        $line[$i] = "L";
                    }
                }
                $this->structure[$layerID][$lineID] = implode("", $line);
            }
        }
    }

	protected function getFinalStructure(Level $level, $x, $y, $z){
        //$this->makeDead();
        $this->createLog();
        $this->createLeaves();

        return $this->structure;
		//return parent::getFinalStructure($level, $x, $y, $z);
	}
}