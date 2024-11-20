<?php
namespace GCWorld\Menu;

use GCWorld\Menu\PanelElements\Link;
use GCWorld\Menu\PanelElements\LoginForm;

/**
 * Class MenuBlock
 */
class MenuBlock
{
    protected MenuPanel $parent;

    public    bool    $wrap  = true;
	protected ?string $html  = null;
    protected array   $links = [];

    /**
     * @param MenuPanel $parent
     */
	public function __construct(MenuPanel $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param bool $bool
     * @return $this
     */
    public function setWrap(bool $bool): static
    {
        $this->wrap = $bool;
        return $this;
    }

    /**
     * Note: Disables the links array
     * @param string $html
     * @return $this
     */
    public function setHTML(string $html): static
    {
        $this->html = $html;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getHTML(): ?string
    {
        return $this->html;
    }

    /**
     * @param string $html
     * @return $this
     */
    public function addHTML(string $html): static
    {
        if($this->html === null) {
            $this->html = $html;

            return $this;
        }

        $this->html .= $html;

        return $this;
    }

    /**
     * @param string $id
     * @return Link
     */
    public function addLink(string $id): Link
    {
        $this->links[$id] = new Link($this);

        return $this->links[$id];
    }

    /**
     * @param string $id
     * @return LoginForm
     */
    public function addLoginForm(string $id): LoginForm
    {
        $this->links[$id] = new LoginForm($this);

        return $this->links[$id];
    }

    /**
     * @return string
     */
    public function returnBlock(): string
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
     * @return MenuPanel
     */
    public function getParent(): MenuPanel
    {
        return $this->parent;
    }
}
