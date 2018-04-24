<?php
namespace GCWorld\Menu;

/**
 * Class DropDownWide
 * @package GCWorld\Menu
 */
class DropDownWide
{
    protected $panels     = [];
    protected $html       = null;
    public    $id         = null;
    public    $default    = null;

    /**
     * DropDownWide constructor.
     * @param string $id
     */
    public function __construct(string $id)
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
        $this->panels[$id] = [
            'id'    => $id,
            'name'  => $name,
            'obj'   => new MenuPanel($this)
        ];
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

    /**
     * @return string
     */
    public function returnPanels()
    {
        $out = '';

        if($this->html !== null) {
            $out .= '<div class="row '.$this->getPanelClass().'" id="MENU_'.$this->id.'">';
            $out .= $this->html;
            $out .= '</div>';
            return $out;
        }

        foreach ($this->panels as $panel) {
            $out .= '<div class="row '.$this->getPanelClass().'" id="MENU_'.$panel['id'].'" '.($panel['id']==$this->default?'':'style="display:none"').'>';
            $out .= $panel['obj']->returnPanel();
            $out .= '</div>';
        }

        return $out;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setDefault(string $id)
    {
        $this->default = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPanelClass()
    {
        return 'WIDE_PANEL_CLASS_'.$this->id;
    }

    /**
     * @param string $html
     */
    public function setOverrideHtml(string $html)
    {
        $this->html = $html;
    }
}
