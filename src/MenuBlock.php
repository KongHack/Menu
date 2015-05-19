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
	 * @return \GCWorld\Menu\PanelElements\Link
	 */
	public function addLink($id)
	{
		$this->links[$id] = new PanelElements\Link($this);
		return $this->links[$id];
	}

	/**
	 * @param $id
	 * @return \GCWorld\Menu\PanelElements\LoginForm
	 */
	public function addLoginForm($id)
	{
		$this->links[$id] = new PanelElements\LoginForm($this);
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
