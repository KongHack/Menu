<?php
namespace GCWorld\Menu;

/**
 * Class DropDownNotices
 */
class DropDownNotices
{
    protected $items  = [];
    protected $id     = null;
    protected $empty  = 'N/A';

    /**
     * DropDownNotices constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $html
     *
     * @return $this
     */
    public function setEmptyHtml(string $html)
    {
        $this->empty = $html;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmptyHtml()
    {
        return $this->empty;
    }

    /**
     * @param string $icon
     * @param string $message
     * @param string $url
     * @param string $class
     * @return $this
     */
    public function addItem(string $icon, string $message, string $url, string $class = '')
    {
        $this->items[] = [
            'icon'    => $icon,
            'message' => $message,
            'url'     => $url,
            'class'   => $class,
        ];

        return $this;
    }


    /**
     * @return string
     */
    public function render()
    {
        $html = '<ul id="'.$this->id.'" class="dropdown-menu notification-dropdown-menu">';
        if(!empty($this->items)) {
            foreach($this->items as $item) {
                $html .= '<li class="notification-li">';
                $html .= '<a class="notification-entry '.$item['class'].'" href="'.$item['url'].'">';
                $html .= '<span class="notification-icon">'.$item['icon'].'</span>';
                $html .= '<span class="notification-message">'.$item['message'].'</span>';
                $html .= '</a>';
                $html .= '</li>';
            }
        } else {
            $html .= '<li><div class="notification-menu-empty">'.$this->empty.'</div></li>';
        }

        $html .= '</ul>';

        return $html;
    }
}
