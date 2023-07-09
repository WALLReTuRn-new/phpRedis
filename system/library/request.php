<?php
/**
* Request class
*/
namespace WebSiteToYou\System\Library;
class Request {
	public array $get = [];
	public array $post = [];
	public array $cookie = [];
	public array $files = [];
	public array $server = [];
	public array $request = [];
	
	/**
	 * Constructor
 	*/
	public function __construct() {
		$this->get = $this->clean($_GET);
		$this->post = $this->clean($_POST);
		$this->request = $this->clean($_REQUEST);
		$this->cookie = $this->clean($_COOKIE);
		$this->files = $this->clean($_FILES);
		$this->server = $this->clean($_SERVER);
	}
	
	/**
     * 
	 * @param	array	$data
	 *
     * @return	array
     */
	public function clean(mixed $data): mixed {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				unset($data[$key]);

				$data[$this->clean($key)] = $this->clean($value);
			}
		} else {
			$data = trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
		}

		return $data;
	}
}
