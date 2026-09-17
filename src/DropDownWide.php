<?php
namespace GCWorld\Menu;

use GCWorld\Menu\Core\Twig;

/**
 * Class DropDownWide
 */
class DropDownWide
{
    /** @var array<string,array{id:string,name:string,obj:MenuPanel}> */
    protected array $panels = [];
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
        return Twig::render('@GCMenu/drop_down_wide.twig', [
            'id'      => $this->id,
            'html'    => $this->html,
            'panels'  => $this->panels,
            'default' => $this->default,
            'class'   => $this->getPanelClass(),
        ]);
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
