<?php
namespace GCWorld\Menu;

class Menu
{
	private $panels     = array();
	public  $id         = null;
	public  $default    = null;

	public function __construct($id)
	{
		$this->id = $id;
	}


	/**
	 * @param $id
	 * @param $name
	 * @return \GCWorld\Menu\MenuPanel
	 */
	public function addPanel($id, $name)
	{
		$this->panels[$id] = array(
			'id'    => $id,
			'name'  => $name,
			'obj'   => new MenuPanel($this)
		);
		return $this->panels[$id]['obj'];
	}


	/**
	 * @param $id
	 * @return \GCWorld\Menu\MenuPanel
	 */
	public function getPanel($id)
	{
		return $this->panels[$id]['obj'];
	}

	public function returnPanels()
	{
		$out = '';
		foreach($this->panels as $panel)
		{
			$out .= '<div class="row '.$this->getPanelClass().'" id="'.$panel['id'].'" '.($panel['id']==$this->default?'':'style="display:none"').'>';
			$out .= $panel['obj']->returnPanel();
			$out .= '</div>';
		}
		return $out;
	}

	public function setDefault($id)
	{
		$this->default = $id;
	}

	public function getPanelClass()
	{
		return 'MENU_PANEL_CLASS_'.$this->id;
	}
}
