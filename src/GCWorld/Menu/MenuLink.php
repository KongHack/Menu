<?php
namespace GCWorld\Menu;

class MenuLink
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

	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setClass($class)
	{
		$this->class = $class;
	}

	public function setClick($click)
	{
		$this->click = $click;
	}

	public function setLoader($loader)
	{
		$this->panel_loader = $loader;
	}

	public function setNewWindow()
	{
		$this->new_win = true;
		$this->ajaxy = false;
	}

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
			$out .= '$(\'.'.$panelClass.'\').fadeOut(function(){$(\'#MENU_'.$this->panel_loader.'\').fadeIn();}); return false;';
			$out .= '"';
		}
		$out .= '>'.$this->name.'</a></p>';

		return $out;
	}

	/*
	 * @return \GCWorld\Menu\MenuBlock
	 */
	public function getParent()
	{
		return $this->parent;
	}

}
