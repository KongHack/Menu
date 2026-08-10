<?php
namespace GCWorld\Menu;

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

    protected array   $menuElements = [];
    protected string  $menuTitle    = '';
    protected string  $menuLogo     = '';
    protected string  $menuUrl      = '';
    protected ?string $brandOverride = null;

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
        $brand = $this->brandOverride ?? ('<a class="navbar-brand" href="'.$this->menuUrl.'">
            <img src="'.$this->menuLogo.'" alt="'.$this->menuTitle.'">'.
        '</a>');

        $out = '
        <nav class="navbar yamm navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				'.$brand.'
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				';
        if($this->googleSearchURL != null) {
            $out .= '
            <form class="navbar-form navbar-left" role="search" action="'.$this->googleSearchURL.'" id="cse-search-box">
                <div class="form-group">
                    <input type="hidden" name="cof" value="FORID:10">
                    <input type="hidden" name="ie" value="UTF-8">
                    <input type="hidden" name="sa" value="Search">
                    <div class="input-group" style="width:150px;">
                        <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input type="text" class="form-control ui-autocomplete-input" placeholder="Search" name="q" id="header_search" autocomplete="off">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
            ';
        } elseif ($this->searchForm != null) {
            $out .= $this->searchForm;
        }

        $out .= $this->renderElements();

        $out .= '
            </div>
		</nav>';

        return $out;
    }

    /**
     * @return string
     */
    public function renderElements(): string
    {
        $out = '';
        foreach ($this->menuElements as $alignment => $elements) {
            if ($alignment == 'L') {
                $out .= '<ul class="nav navbar-nav">';
            } else {
                $out .= '<ul class="nav navbar-nav navbar-right">';
            }

            foreach ($elements as $element_id => $element) {
                switch($element['type']) {
                    case self::ELEMENT_LINK:
                        $out .= '<li id="'.$element_id.'"><a href="'.$element['url'].'" '.($element['new_win']?' class="no-ajaxy" target="_blank"':'').'>'.$element['title'].'</a></li>';
                        break;
                    case self::ELEMENT_DROP_NORMAL:
                        $out .= '
                        <li class="dropdown" id="'.$element_id.'">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$element['title'].' <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="yamm-content">
                                        <div class="row">
                                            <div class="col-sm-12">
												'.$element['obj']->returnPanels().'
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
						';
                        break;
                    case self::ELEMENT_DROP_WIDE:
                        $out .= '
                        <li class="dropdown yamm-fw" id="'.$element_id.'">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$element['title'].' <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="yamm-content">
										'.$element['obj']->returnPanels().'
                                    </div>
                                </li>
                            </ul>
                        </li>
						';
                        break;
                    case self::ELEMENT_DROP_HTML:
                        $out .= '
                        <li class="dropdown yamm-fw" id="'.$element_id.'">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$element['title'].' <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="yamm-content">
										'.$element['obj']->getHTML().'
                                    </div>
                                </li>
                            </ul>
                        </li>
						';
                        break;
                    case self::ELEMENT_DROP_NOTICE:
                        $out .= '
                        <li class="dropdown" id="'.$element_id.'">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$element['title'].' <b class="caret"></b></a>
                            '.$element['obj']->render().'
                        </li>
						';
                        break;
                    case self::ELEMENT_HTML:
                        $out .= $element['html'];
                        break;
                }
            }
            $out .= '</ul>';
        }

        return $out;
    }
}
