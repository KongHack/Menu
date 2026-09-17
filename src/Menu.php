<?php
namespace GCWorld\Menu;

use GCWorld\Menu\Core\Twig;

/**
 * Class Menu
 */
class Menu
{
    protected const ELEMENT_LINK        = 'L';
    protected const ELEMENT_DROP_NORMAL = 'D';
    protected const ELEMENT_DROP_WIDE   = 'W';
    protected const ELEMENT_DROP_NOTICE = 'N';
    protected const ELEMENT_DROP_HTML   = 'X';
    protected const ELEMENT_HTML        = 'H';

    /** @var array<string,array<string,array<string,mixed>>> */
    protected array   $menuElements       = [];
    protected string  $menuTitle          = '';
    protected string  $menuLogo           = '';
    protected string  $menuUrl            = '';
    protected ?string $brandOverride      = null;
    protected ?string $navbarBrandOverlay = null;

    public ?string $googleSearchURL = null;
    public ?string $searchForm      = null;

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->menuTitle = $title;
        return $this;
    }

    /**
     * @param string $logo
     * @return $this
     */
    public function setLogo(string $logo): static
    {
        $this->menuLogo = $logo;
        return $this;
    }

    /**
     * Sets the base url that the logo will act upon
     * @param string $url
     * @return $this
     */
    public function setURL(string $url): static
    {
        $this->menuUrl = $url;
        return $this;
    }

    /**
     * @param string|null $overlay
     * @return $this
     */
    public function setNavbarBrandOverlay(?string $overlay): static
    {
        $this->navbarBrandOverlay = $overlay;
        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param string $url
     * @param bool   $new_win
     * @param bool   $right
     * @return $this
     */
    public function addLink(string $id, string $title, string $url, bool $new_win = false, bool $right = false): static
    {
        $this->menuElements[($right?'R':'L')][$id] = [
            'type'    => self::ELEMENT_LINK,
            'title'   => $title,
            'url'     => $url,
            'new_win' => $new_win
        ];
        return $this;
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool   $right
     * @return DropDownNormal
     */
    public function addDropDown(string $id, string $title, bool $right = false): DropDownNormal
    {
        $this->menuElements[($right?'R':'L')][$id] = array(
            'type'  => self::ELEMENT_DROP_NORMAL,
            'title' => $title,
            'right' => $right,
            'obj'   => new DropDownNormal($id)
        );
        return $this->menuElements[($right?'R':'L')][$id]['obj'];
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool   $right
     * @return DropDownWide
     */
    public function addDropDownWide(string $id, string $title, bool $right = false): DropDownWide
    {
        $this->menuElements[($right?'R':'L')][$id] = array(
            'type'  => self::ELEMENT_DROP_WIDE,
            'title' => $title,
            'right' => $right,
            'obj'   => new DropDownWide($id)
        );
        return $this->menuElements[($right?'R':'L')][$id]['obj'];
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool   $right
     * @return DropDownNotices
     */
    public function addDropDownNotice(string $id, string $title, bool $right = false): DropDownNotices
    {
        $this->menuElements[($right?'R':'L')][$id] = [
            'type'  => self::ELEMENT_DROP_NOTICE,
            'title' => $title,
            'right' => $right,
            'obj'   => new DropDownNotices($id)
        ];
        return $this->menuElements[($right?'R':'L')][$id]['obj'];
    }
    
    /**
     * @param string $id
     * @param string $title
     * @param bool   $right
     * @return DropDownHTML
     */
    public function addDropDownHTML(string $id, string $title, bool $right = false): DropDownHTML
    {
        $this->menuElements[($right?'R':'L')][$id] = [
            'type'  => self::ELEMENT_DROP_HTML,
            'title' => $title,
            'right' => $right,
            'obj'   => new DropDownHTML($id)
        ];
        return $this->menuElements[($right?'R':'L')][$id]['obj'];
    }

    /**
     * @param string $id
     * @param string $html
     * @param bool   $right
     * @return void
     */
    public function addHTML(string $id, string $html, bool $right = false): void
    {
        $this->menuElements[($right?'R':'L')][$id] = [
            'type'  => self::ELEMENT_HTML,
            'html'  => $html,
            'right' => $right
        ];
    }

    /**
     * @return string
     */
    public function returnMenu(): string
    {
        return Twig::render('@GCMenu/menu.twig', [
            'menu_title'           => $this->menuTitle,
            'menu_logo'            => $this->menuLogo,
            'menu_url'             => $this->menuUrl,
            'brand_override'       => $this->brandOverride,
            'navbar_brand_overlay' => $this->navbarBrandOverlay,
            'google_search_url'    => $this->googleSearchURL,
            'search_form'          => $this->searchForm,
            'elements'             => $this->renderElements(),
        ]);
    }

    /**
     * @return string
     */
    public function renderElements(): string
    {
        return Twig::render('@GCMenu/menu_elements.twig', [
            'menu_elements' => $this->menuElements,
            'types'         => [
                'link'        => self::ELEMENT_LINK,
                'drop_normal' => self::ELEMENT_DROP_NORMAL,
                'drop_wide'   => self::ELEMENT_DROP_WIDE,
                'drop_notice' => self::ELEMENT_DROP_NOTICE,
                'drop_html'   => self::ELEMENT_DROP_HTML,
                'html'        => self::ELEMENT_HTML,
            ],
        ]);
    }
}
