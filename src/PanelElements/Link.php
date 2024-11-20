<?php
namespace GCWorld\Menu\PanelElements;

use GCWorld\Menu\MenuBlock;

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
    protected bool $new_win         = false;
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
        $this->new_win = true;
        $this->ajaxy = false;
        return $this;
    }

    /**
     * @return bool
     */
    public function getNewWindow(): bool
    {
        return $this->new_win;
    }

    /**
     * @return string
     */
    public function returnButton(): string
    {
        $out = '<p>';
        if ($this->panel_loader == null) {
            $out .= '<a href="'.$this->url.'" class="btn btn-'.$this->class.' btn-block '.($this->ajaxy ? '' : 'no-ajaxy').'"';
            if ($this->click != '') {
                $out .= ' onclick="'.addslashes($this->click).'"';
            }
            if ($this->new_win) {
                $out .= ' target="_blank"';
            }
        } else {
            $panelClass = $this->getParent()->getParent()->getParent()->getPanelClass();

            $out .= '<a class="btn btn-'.$this->class.' btn-block no-ajaxy" onclick="';
            $out .= '$(\'.'.$panelClass.':not(#MENU_'.$this->panel_loader.')\').fadeOut(\'fast\', function(){$(\'#MENU_'.$this->panel_loader.'\').fadeIn(\'fast\');}); return false;';
            $out .= '"';
        }
        $out .= '>'.$this->name.'</a></p>';

        return $out;
    }

    /**
     * @return MenuBlock
     */
    public function getParent(): MenuBlock
    {
        return $this->parent;
    }
}
