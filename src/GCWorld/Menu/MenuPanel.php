<?php
namespace GCWorld\Menu;

class MenuPanel
{
	private $blocks = array();
	private $parent = null;

	public function __construct($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @param $id
	 * @param $name
	 * @return \GCWorld\Menu\MenuBlock
	 */
	public function addBlock($id, $name)
	{
		$this->blocks[$id] = array(
			'id'    => $id,
			'name'  => $name,
			'obj'   => new MenuBlock($this)
		);
		return $this->blocks[$id]['obj'];
	}

	/**
	 * @param $id
	 * @return \GCWorld\Menu\MenuBlock
	 */
	public function getBlock($id)
	{
		return $this->blocks[$id]['obj'];
	}

	/**
	 * @return string
	 */
	public function returnPanel()
	{
		$out = '';
		foreach($this->blocks as $block)
		{
			$out .= '<div class="col-sm-'.floor(12/count($this->blocks)).'">';
			$out .= '<div class="panel panel-sitespecific">';
			$out .= '<div class="panel-heading"><div class="panel-title">'.$block['name'].'</div></div>';
			$out .= '<div class="panel-body">';
			$out .= $block['obj']->returnBlock();
			$out .= '</div>';
			$out .= '</div>';
			$out .= '</div>';
		}
		return $out;
	}

	/**
	 * @return \GCWorld\Menu\Menu
	 */
	public function getParent()
	{
		return $this->parent;
	}

}
