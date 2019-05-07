<?php
namespace GCWorld\Menu\PanelElements;

class Link
{
    protected $url            = '#';
    protected $name           = '';
    protected $class          = 'primary';
    protected $click          = null;
    protected $new_win        = false;
    protected $ajaxy          = true;
    protected $panel_loader   = null;
    protected $parent         = null;

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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return string
     */
    public function getClass()
    {
        return $this->class;
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
     * @return mixed
     */
    public function getClick()
    {
        return $this->click;
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
     * @return mixed
     */
    public function getLoader()
    {
        return $this->panel_loader;
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
     * @return bool
     */
    public function getNewWindow()
    {
        return $this->new_win;
    }

    /**
     * @return string
     */
    public function returnButton()
    {
        $out = '<p>';
        if ($this->panel_loader == null) {
            $out .= '<a href="'.$this->url.'" class="btn btn-'.$this->class.' btn-block '.($this->ajaxy ? '' : 'no-ajaxy').'"';
            if ($this->click != '') {
                $out .= ' onclick="'.addslashes($this->click).'"';
            }
            if ($this->new_win) {
                $out .= ' target="_blank"';
            }
        } else {
            $panelClass = $this->getParent()->getParent()->getParent()->getPanelClass();

            $out .= '<a class="btn btn-'.$this->class.' btn-block no-ajaxy" onclick="';
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
