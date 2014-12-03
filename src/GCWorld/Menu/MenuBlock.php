<?php
namespace GCWorld\Menu;

class MenuBlock
{
	private $links  = array();
	private $parent = null;

	public function __construct($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @param $id
	 * @return \GCWorld\Menu\MenuLink
	 */
	public function addLink($id)
	{
		$this->links[$id] = new MenuLink($this);
		return $this->links[$id];
	}

	/**
	 * @return string
	 */
	public function returnBlock()
	{
		$out = '';
		foreach($this->links as $link)
		{
			$out .= $link->returnButton();
		}
		return $out;
	}

	/**
	 * @return \GCWorld\Menu\MenuPanel
	 */
	public function getParent()
	{
		return $this->parent;
	}

}
