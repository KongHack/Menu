<?php
namespace GCWorld\Menu;

use GCWorld\Menu\Core\Twig;

/**
 * Class MenuPanel
 */
class MenuPanel
{
    protected DropDownWide|DropDownNormal $parent;

    /** @var array<string,array{id:string,name:string,obj:MenuBlock}> */
    protected array $blocks = [];

    public function __construct(DropDownWide|DropDownNormal $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param string $id
     * @param string $name
     * @return MenuBlock
     */
    public function addBlock(string $id, string $name): MenuBlock
    {
        $this->blocks[$id] = array(
            'id'    => $id,
            'name'  => $name,
            'obj'   => new MenuBlock($this)
        );

        return $this->blocks[$id]['obj'];
    }

    /**
     * @param string $id
     * @return MenuBlock
     */
    public function getBlock(string $id): MenuBlock
    {
        return $this->blocks[$id]['obj'];
    }

    /**
     * @param bool $slim
     * @return string
     */
    public function returnPanel(bool $slim = false): string
    {
        $columnWidth = empty($this->blocks) ? 12 : floor(12/count($this->blocks));

        return Twig::render('@GCMenu/menu_panel.twig', [
            'blocks'       => $this->blocks,
            'slim'         => $slim,
            'column_width' => $columnWidth,
        ]);
    }

    /**
     * @return DropDownWide|DropDownNormal
     */
    public function getParent(): DropDownWide|DropDownNormal
    {
        return $this->parent;
    }
}
