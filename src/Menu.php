<?php
namespace GCWorld\Menu;

class Menu
{
    private $menu_elements  = array();
    private $menu_title     = '';
    private $menu_logo      = '';
    private $menu_url       = '';

    public $legacySearch    = false;

    public $googleSearchURL = null;
    public $searchForm      = null;

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->menu_title = $title;
        return $this;
    }

    /**
     * @param $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->menu_logo = $logo;
        return $this;
    }

    /**
     * Sets the base url that the logo will act upon
     * @param $url
     * @return $this
     */
    public function setURL($url)
    {
        $this->menu_url = $url;
        return $this;
    }

    /**
     * @return $this
     */
    public function enableLegacySearch()
    {
        $this->legacySearch = true;
        return $this;
    }

    /**
     * @param            $id
     * @param            $title
     * @param            $url
     * @param bool|false $new_win
     * @param bool|false $right
     * @return $this
     */
    public function addLink($id, $title, $url, $new_win = false, $right = false)
    {
        $this->menu_elements[($right?'R':'L')][$id] = [
            'type'    =>'L',
            'title'   =>$title,
            'url'     =>$url,
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
    public function addDropDown($id, $title, $right = false)
    {
        $this->menu_elements[($right?'R':'L')][$id] = array(
            'type'  => 'D',
            'title' => $title,
            'right' => $right,
            'obj'   => new DropDownNormal($id)
        );
        return $this->menu_elements[($right?'R':'L')][$id]['obj'];
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool   $right
     * @return DropDownWide
     */
    public function addDropDownWide(string $id, string $title, bool $right = false)
    {
        $this->menu_elements[($right?'R':'L')][$id] = array(
            'type'  => 'W',
            'title' => $title,
            'right' => $right,
            'obj'   => new DropDownWide($id)
        );
        return $this->menu_elements[($right?'R':'L')][$id]['obj'];
    }

    /**
     * @param string $id
     * @param string $title
     * @param bool   $right
     * @return DropDownNotices
     */
    public function addDropDownNotice(string $id, string $title, bool $right = false)
    {
        $this->menu_elements[($right?'R':'L')][$id] = array(
            'type'  => 'N',
            'title' => $title,
            'right' => $right,
            'obj'   => new DropDownNotices($id)
        );
        return $this->menu_elements[($right?'R':'L')][$id]['obj'];
    }

    /**
     * @param string $id
     * @param string $html
     * @param bool   $right
     */
    public function addHTML(string $id, string $html, bool $right = false)
    {
        $this->menu_elements[($right?'R':'L')][$id] = array(
            'type'  => 'H',
            'html'  => $html,
            'right' => $right
        );
    }

    /**
     * @return string
     */
    public function returnMenu()
    {
        $out = '
        <nav class="navbar yamm navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a class="navbar-brand" href="'.$this->menu_url.'"><img src="'.$this->menu_logo.'" alt="'.$this->menu_title.'"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				';
        if($this->legacySearch == true) {
            $out .= '
            <form class="navbar-form navbar-left" role="search" action="/search_results.php" id="cse-search-box">
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
        } elseif($this->googleSearchURL != null) {
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

        foreach ($this->menu_elements as $alignment => $elements) {
            if ($alignment == 'L') {
                $out .= '<ul class="nav navbar-nav">';
            } else {
                $out .= '<ul class="nav navbar-nav navbar-right">';
            }

            foreach ($elements as $element_id => $element) {
                switch($element['type'])
                {
                    case 'L':
                        $out .= '<li id="'.$element_id.'"><a href="'.$element['url'].'" '.($element['new_win']?' class="no-ajaxy" target="_blank"':'').'>'.$element['title'].'</a></li>';
                        break;
                    case 'D':
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
                    case 'W':
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

                    case 'N':
                        $out .= '
                        <li class="dropdown" id="'.$element_id.'">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$element['title'].' <b class="caret"></b></a>
                            '.$element['obj']->render().'
                        </li>
						';
                        break;

                    case 'H':
                        $out .= $element['html'];
                        break;
                }
            }
            $out .= '</ul>';
        }

        $out .= '
            </div>
		</nav>';

        return $out;
    }
}
