<?php
namespace GCWorld\Menu;

use GCWorld\Menu\Components\DropDownNoticeItem;

/**
 * Class DropDownNotices
 */
class DropDownNotices
{
    protected string $id;

    /**
     * @var DropDownNoticeItem[]
     */
    protected array $items  = [];
    protected string $empty = 'N/A';

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
        $cObj = new DropDownNoticeItem();
        $cObj->setIcon($icon);
        $cObj->setMessage($message);
        $cObj->setUrl($url);
        $cObj->setClass($class);

        $this->items[] = $cObj;

        return $this;
    }

    /**
     * @param DropDownNoticeItem $cItem
     * @return $this
     */
    public function addItemObject(DropDownNoticeItem $cItem)
    {
        $this->items[] = $cItem;

        return $this;
    }


    /**
     * @return string
     */
    public function render()
    {
        $html = '<ul id="'.$this->id.'_list" class="dropdown-menu notification-dropdown-menu">';
        if(empty($this->items)) {
            $html .= '<li><div class="notification-menu-empty">' . $this->empty . '</div></li>';
            return $html.'</ul>';
        }
        foreach($this->items as $item) {
            $html .= $item->getHtml();
        }

        $html .= '</ul>';
        return $html;
    }
}
