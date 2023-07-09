<?php
/**
* Event class
*
* Event System
* 
*/
namespace WebSiteToYou\System\Library;
class Event {
	protected $registry;
	protected array $data = [];
	
	/**
	 * Constructor
	 *
	 * @param	object	$route
 	*/
	public function __construct(\WebSiteToYou\System\Library\Registry $registry) {
		$this->registry = $registry;
	}
	
	/**
	 * 
	 *
	 * @param	string	$trigger
	 * @param	object	$action
	 * @param	int		$priority
 	*/	
	public function register(string $trigger, \WebSiteToYou\System\Library\Action $action, int $priority = 0): void {
		$this->data[] = [
			'trigger'  => $trigger,
			'action'   => $action,
			'priority' => $priority
		];
		
		$sort_order = [];

		foreach ($this->data as $key => $value) {
			$sort_order[$key] = $value['priority'];
		}

		array_multisort($sort_order, SORT_ASC, $this->data);	
	}
	
	/**
	 * 
	 *
	 * @param	string	$event
	 * @param	array	$args
 	*/		
	public function trigger(string $event, array $args = []): mixed {
            
            
            
		foreach ($this->data as $value) {
			if (preg_match('/^' . str_replace(['\*', '\?'], ['.*', '.'], preg_quote($value['trigger'], '/')) . '/', $event)) {
				$result = $value['action']->execute($this->registry, $args);

				if (!is_null($result) && !($result instanceof \Exception)) {
					return $result;
				}
			}
		}

		return '';
	}
	
	/**
	 * 
	 *
	 * @param	string	$trigger
	 * @param	string	$route
 	*/	
	public function unregister(string $trigger, string $route): void {
		foreach ($this->data as $key => $value) {
			if ($trigger == $value['trigger'] && $value['action']->getId() == $route) {
				unset($this->data[$key]);
			}
		}			
	}
	
	/**
	 * 
	 *
	 * @param	string	$trigger
 	*/		
	public function clear(string $trigger): void {
		foreach ($this->data as $key => $value) {
			if ($trigger == $value['trigger']) {
				unset($this->data[$key]);
			}
		}
	}	
}
