<?php
namespace GCWorld\Menu;

/**
 * Class MenuPanel
 */
class MenuPanel
{
    protected DropDownWide|DropDownNormal $parent;

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
        $out = '';
        foreach ($this->blocks as $block) {
            /** @var MenuBlock $obj */
            $obj = $block['obj'];

            $out .= '<div class="col-sm-'.floor(12/count($this->blocks)).'">';
            if (!$slim && $block['name'] != 'Spacer' && $obj->wrap) {
                $out .= '<div class="panel panel-sitespecific">';
                $out .= '<div class="panel-heading"><div class="panel-title">'.$block['name'].'</div></div>';
                $out .= '<div class="panel-body">';
            }
            $out .= $obj->returnBlock();
            if (!$slim && $block['name'] != 'Spacer' && $obj->wrap) {
                $out .= '</div>';
                $out .= '</div>';
            }
            $out .= '</div>';
        }
        return $out;
    }

    /**
     * @return DropDownWide|DropDownNormal
     */
    public function getParent(): DropDownWide|DropDownNormal
    {
        return $this->parent;
    }
}
