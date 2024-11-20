<?php
namespace GCWorld\Menu;

/**
 * Class DropDownWide
 */
class DropDownWide
{
    protected array  $panels   = [];
    protected ?string $html    = null;
    public    ?string $default = null;
    public    string  $id;

    /**
     * DropDownWide constructor.
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
    public function setDefault(string $id): static
    {
        $this->default = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPanelClass(): string
    {
        return 'WIDE_PANEL_CLASS_'.$this->id;
    }

    /**
     * @param string $html
     */
    public function setOverrideHtml(string $html): void
    {
        $this->html = $html;
    }
}
