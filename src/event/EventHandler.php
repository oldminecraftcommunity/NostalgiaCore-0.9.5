<?php

abstract class EventHandler{

	public static function callEvent(BaseEvent $event){
		$status = BaseEvent::NORMAL;
		foreach($event::$handlerPriority as $priority => $handlerList){
			if(count($handlerList) > 0){
				$event->setPrioritySlot($priority);
				foreach($handlerList as $handler){
					call_user_func($handler, $event);
				}
				if($event->isForced()){
					if($event instanceof CancellableEvent and $event->isCancelled()){
						return BaseEvent::DENY;
					}else{
						return BaseEvent::ALLOW;
					}
				}			
			}
		}

		if($event instanceof CancellableEvent and $event->isCancelled()){
			return BaseEvent::DENY;
		}elseif($event->isAllowed()){
			return BaseEvent::ALLOW;
		}else{
			return BaseEvent::NORMAL;
		}

	}

}