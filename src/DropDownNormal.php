<?php
namespace GCWorld\Menu;

use GCWorld\Menu\Core\Twig;

/**
 * Class DropDownNormal
 */
class DropDownNormal
{
    public string $id;
    /** @var array<string,array{id:string,name:string,obj:MenuPanel}> */
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
        return Twig::render('@GCMenu/drop_down_normal.twig', [
            'panels' => $this->panels,
            'class'  => $this->getPanelClass(),
        ]);
    }

    /**
     * @return string
     */
    public function getPanelClass(): string
    {
        return 'NORMAL_PANEL_CLASS_'.$this->id;
    }
}
