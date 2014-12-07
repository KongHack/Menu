<?php
namespace GCWorld\Menu;

class PanelElements_Link
{
	private $url            = '#';
	private $name           = '';
	private $class          = 'primary';
	private $click          = null;
	private $new_win        = false;
	private $ajaxy          = true;
	private $panel_loader   = null;
	private $parent         = null;

	public function __construct($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @param $url
	 * @return $this
	 */
	public function setUrl($url)
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * @param $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @param $class
	 * @return $this
	 */
	public function setClass($class)
	{
		$this->class = $class;
		return $this;
	}

	/**
	 * @param $click
	 * @return $this
	 */
	public function setClick($click)
	{
		$this->click = $click;
		return $this;
	}

	/**
	 * @param $loader
	 * @return $this
	 */
	public function setLoader($loader)
	{
		$this->panel_loader = $loader;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function setNewWindow()
	{
		$this->new_win = true;
		$this->ajaxy = false;
		return $this;
	}

	/**
	 * @return string
	 */
	public function returnButton()
	{
		$out = '<p>';
		if($this->panel_loader == null)
		{
			$out .= '<a href="'.$this->url.'" class="btn btn-'.$this->class.' btn-block '.($this->ajaxy ? '' : 'no-ajaxy').'"';
			if($this->click != '')
			{
				$out .= ' onclick="'.addslashes($this->click).'"';
			}
			if($this->new_win)
			{
				$out .= ' target="_blank"';
			}
		}
		else
		{
			$panelClass = $this->getParent()->getParent()->getParent()->getPanelClass();

			$out .= '<a href="#" class="btn btn-'.$this->class.' btn-block no-ajaxy" onclick="';
			$out .= '$(\'.'.$panelClass.':not(#MENU_'.$this->panel_loader.')\').fadeOut(\'fast\', function(){$(\'#MENU_'.$this->panel_loader.'\').fadeIn(\'fast\');}); return false;';
			$out .= '"';
		}
		$out .= '>'.$this->name.'</a></p>';

		return $out;
	}

	/**
	 * @return \GCWorld\Menu\MenuBlock
	 */
	public function getParent()
	{
		return $this->parent;
	}

}
