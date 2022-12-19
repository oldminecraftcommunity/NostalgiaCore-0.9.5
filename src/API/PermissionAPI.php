<?php

class PermissionAPI
{
    /**
     * @var GroupBase[]
     */
    public $groups = [];
    /**
     * @var PocketMinecraftServer
     */
    private $server;
    public function __construct(){
        $this->server = ServerAPI::request();
    }
    public function init(){
        $this->addGroup(new DefaultGroup());
        $this->addGroup(new OperatorGroup());
    }
    
    public function getGroupByName($name){
        return $this->groups[$name];
    }
   
    public function addGroup(GroupBase $group){
        if($this->groupExists($group->name)){
            return false;
        }
        $this->groups[$group->name] = $group;
        return true;
    }
    
    public function groupExists($name){
        return isset($this->groups[$name]);
    }
    
    public function removeGroup(GroupBase $group){
        if(!$this->groupExists($group->name)){
            return false;
        }
        unset($this->groups[$group->name]);
        return true;
    }
    
}

