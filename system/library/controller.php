<?php
/**
 * Controller class
 */
namespace WebSiteToYou\System\Library;
class Controller {
	protected $registry;

	public function __construct(\WebSiteToYou\System\Library\Registry $registry) {
		$this->registry = $registry;
	}

	public function __get(string $key): object {
		if ($this->registry->has($key)) {
			return $this->registry->get($key);
		} else {
			throw new \Exception('Error: Could not call registry key ' . $key . '!');
		}
	}

	public function __set(string $key, object $value): void {
		$this->registry->set($key, $value);
	}
        
        
}