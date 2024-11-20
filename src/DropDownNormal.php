<?php
namespace GCWorld\Menu;

/**
 * Class DropDownNormal
 */
class DropDownNormal
{
    public string $id;
    public ?string $default = null;
    protected array $panels = [];

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
    public function addPanel(string $id, string $name): MenuPanel
    {
        $this->panels[$id] = [
            'id'    => $id,
            'name'  => $name,
            'obj'   => new MenuPanel($this)
        ];
        return $this->panels[$id]['obj'];
    }

    /**
     * @param string $id
     * @return MenuPanel
     */
    public function getPanel(string $id): MenuPanel
    {
        return $this->panels[$id]['obj'];
    }

    /**
     * @return string
     */
    public function returnPanels(): string
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
     * @param string $id
     * @return void
     */
    public function setDefault(string $id): void
    {
        $this->default = $id;
    }

    /**
     * @return string
     */
    public function getPanelClass(): string
    {
        return 'NORMAL_PANEL_CLASS_'.$this->id;
    }
}
