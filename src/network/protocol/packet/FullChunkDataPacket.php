<?php

class FullChunkDataPacket extends RakNetDataPacket{
        public $chunkX;
        public $chunkZ;
        public $data;

        public function pid(){
                return ProtocolInfo::FULL_CHUNK_DATA_PACKET;
        }

        public function decode(){

        }

        public function encode(){
                $this->reset();
                $this->put($this->data);
        }

}
