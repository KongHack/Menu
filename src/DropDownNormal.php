<?php
namespace GCWorld\Menu;

/**
 * Class DropDownNormal
 */
class DropDownNormal
{
    protected $panels = [];
    public $id        = null;
    public $default   = null;

    /**
     * DropDownNormal constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $id
     * @param string $name
     * @return MenuPanel
     */
    public function addPanel(string $id, string $name)
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

    /**
     * @return string
     */
    public function returnPanels()
    {
        $out = '';
        foreach ($this->panels as $panel) {
            $out .= '<div class="row '.$this->getPanelClass().'">';
            $out .= $panel['obj']->returnPanel(true);
            $out .= '</div>';
        }
        return $out;
    }

    /**
     * @param $id
     */
    public function setDefault($id)
    {
        $this->default = $id;
    }

    /**
     * @return string
     */
    public function getPanelClass()
    {
        return 'NORMAL_PANEL_CLASS_'.$this->id;
    }
}
