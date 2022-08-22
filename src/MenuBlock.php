<?php
namespace GCWorld\Menu;

/**
 * MenuBlock Class.
 */
class MenuBlock
{
    private $parent = null;

    public  bool    $wrap  = true;
	private ?string $html  = null;
	private array   $links = [];

    /**
     * @param $parent
     */
	public function __construct($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function setWrap($bool)
    {
        $this->wrap = $bool;
        return $this;
    }

    /**
     * Note: Disables the links array
     * @param $html
     * @return $this
     */
    public function setHTML($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getHTML()
    {
        return $this->html;
    }

    /**
     * @param string $html
     * @return $this
     */
    public function addHTML(string $html)
    {
        if($this->html === null) {
            $this->html = $html;

            return $this;
        }

        $this->html .= $html;

        return $this;
    }

    /**
     * @param $id
     * @return \GCWorld\Menu\PanelElements\Link
     */
    public function addLink($id)
    {
        $this->links[$id] = new PanelElements\Link($this);
        return $this->links[$id];
    }

    /**
     * @param $id
     * @return \GCWorld\Menu\PanelElements\LoginForm
     */
    public function addLoginForm($id)
    {
        $this->links[$id] = new PanelElements\LoginForm($this);
        return $this->links[$id];
    }

    /**
     * @return string
     */
    public function returnBlock()
    {
        if ($this->html != null) {
            return $this->html;
        }

        $out = '';
        foreach ($this->links as $link) {
            $out .= $link->returnButton();
        }
        return $out;
    }

    /**
     * @return \GCWorld\Menu\MenuPanel
     */
    public function getParent()
    {
        return $this->parent;
    }
}
