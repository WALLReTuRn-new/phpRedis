<?php
/**
* Document class
*/
namespace WebSiteToYou\System\Library;
class Document {
	private string $title = '';
	private string $description = '';
	private string $keywords = '';
	private array $links = [];
	private array $styles = [];
	private array $scripts = [];

	/**
     *
     *
     * @param	string	$title
     */
	public function setTitle(string $title): void {
		$this->title = $title;
	}

	/**
     *
	 *
	 * @return	string
     */
	public function getTitle(): string {
		return $this->title;
	}

	/**
     *
     *
     * @param	string	$description
     */
	public function setDescription(string $description): void {
		$this->description = $description;
	}

	/**
     *
     *
     * @param	string	$description
	 *
	 * @return	string
     */
	public function getDescription(): string {
		return $this->description;
	}

	/**
     *
     *
     * @param	string	$keywords
     */
	public function setKeywords(string $keywords): void {
		$this->keywords = $keywords;
	}

	/**
     *
	 *
	 * @return	string
     */
	public function getKeywords(): string {
		return $this->keywords;
	}

	/**
     *
     *
     * @param	string	$href
	 * @param	string	$rel
     */
	public function addLink(string $href, string $rel): void {
		$this->links[$href] = [
			'href' => $href,
			'rel'  => $rel
		];
	}

	/**
     *
	 *
	 * @return	array
     */
	public function getLinks(): array {
		return $this->links;
	}

	/**
     *
     *
     * @param	string	$href
	 * @param	string	$rel
	 * @param	string	$media
     */
	public function addStyle(string $href, $rel = 'stylesheet', $media = 'screen'): void {
		$this->styles[$href] = [
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
		];
	}

	/**
     *
	 *
	 * @return	array
     */
	public function getStyles(): array {
		return $this->styles;
	}

	/**
     *
     *
     * @param	string	$href
	 * @param	string	$position
     */
	public function addScript(string $name, string $href, $position): void {
		$this->scripts[$position][$name] = HTTPS_SERVER.$href;
               
	}

	/**
     *
     *
     * @param	string	$position
	 *
	 * @return	array
     */
	public function getScripts($position): array {
            
           // print_r($this->scripts);
            
            
		if (isset($this->scripts[$position])) {
                    
			return $this->scripts[$position];
		} else {
			return [];
		}
	}
}
