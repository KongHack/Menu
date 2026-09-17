<?php
namespace GCWorld\Menu\PanelElements;

use GCWorld\Menu\Core\Twig;
use GCWorld\Menu\DropDownWide;
use GCWorld\Menu\MenuBlock;
use LogicException;

/**
 * Class Link
 */
class Link
{
    protected MenuBlock $parent;
    protected string $url           = '#';
    protected string $name          = '';
    protected string $class         = 'primary';
    protected ?string $click        = null;
    protected bool $newWindow       = false;
    protected bool $ajaxy           = true;
    protected ?string $panel_loader = null;

    /**
     * @param MenuBlock $parent
     */
    public function __construct(MenuBlock $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function setClass(string $class): static
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $click
     * @return $this
     */
    public function setClick(string $click): static
    {
        $this->click = $click;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClick(): ?string
    {
        return $this->click;
    }

    /**
     * @param string $loader
     * @return $this
     */
    public function setLoader(string $loader): static
    {
        if (!$this->parent->getParent()->getParent() instanceof DropDownWide) {
            throw new LogicException('Panel loader links are only supported by wide dropdowns.');
        }

        $this->panel_loader = $loader;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLoader(): ?string
    {
        return $this->panel_loader;
    }

    /**
     * @return $this
     */
    public function setNewWindow(): static
    {
        $this->newWindow = true;
        $this->ajaxy = false;
        return $this;
    }

    /**
     * @return bool
     */
    public function getNewWindow(): bool
    {
        return $this->newWindow;
    }

    /**
     * @return string
     */
    public function returnButton(): string
    {
        $panelClass = null;
        if ($this->panel_loader !== null) {
            $panelClass = $this->getParent()->getParent()->getParent()->getPanelClass();
        }

        return Twig::render('@GCMenu/panel_elements/link.twig', [
            'url'          => $this->url,
            'name'         => $this->name,
            'class'        => $this->class,
            'click'        => $this->click === null ? null : addslashes($this->click),
            'new_window'   => $this->newWindow,
            'ajaxy'        => $this->ajaxy,
            'panel_loader' => $this->panel_loader,
            'panel_class'  => $panelClass,
        ]);
    }

    /**
     * @return MenuBlock
     */
    public function getParent(): MenuBlock
    {
        return $this->parent;
    }
}
