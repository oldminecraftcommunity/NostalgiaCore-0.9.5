<?php

class EntityAI
{
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
    }
    
    /**
     * Add a task for entity
     * @param TaskBase $task
     */
    public function addTask(TaskBase $task){
        console("[DEBUG] Adding new task...",true, true, 2);
        $this->tasks[] = $task;
    }
    
    public function updateTasks(){
        foreach($this->tasks as $t){
            if($t->wasExecuted($this)){
                $t->onUpdate($this);
                continue;
            }
            if($t->shouldBeExecuted($this)){
                $t->onStart($this);
                $t->onUpdate($this);
                $this->lastTask = $this;
            }
        }
    }
    
}

