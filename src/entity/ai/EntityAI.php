<?php

class EntityAI
{
    /**
     * @var MobController
     */
    public $mobController;
    /**
     * @var Living
     */
    public $entity;
    
    /**
     * @var TaskBase[]
     */
    protected $tasks;
    
    public $lastTask;
    
    public function __construct($entity){
        $this->entity = $entity;
        $this->tasks = [];
        $this->mobController = new MobController($entity);
    }
    
    /**
     * Add a task for entity
     * @param TaskBase $task
     */
    public function addTask(TaskBase $task){
        console("[DEBUG] Adding new task...",true, true, 2);
        $this->tasks[$task->__toString()] = $task;
    }
    /**
     * 
     * @param mixed $id classname
     * @return TaskBase | false
     */
    public function getTask($id){
        return $this->tasks[$id] ?: false; //i never saw this operator before
    }
    

    public function updateTasks(){
        foreach($this->tasks as $t){
            if(!$t->isStarted && $t->canBeExecuted($this)){
                $t->isStarted = true;
                $t->onStart($this);
            }
            if($t->isStarted){
                $t->onUpdate($this);
                if($t->selfCounter <= 0){
                    $t->isStarted = false;
                    $t->onEnd($this);
                }
            }
        }
    }
    
    public function __destruct(){
        unset($this->entity);
    }
    
}

