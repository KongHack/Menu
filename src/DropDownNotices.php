<?php
namespace GCWorld\Menu;

use GCWorld\Menu\Components\DropDownNoticeItem;
use GCWorld\Menu\Core\Twig;

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
    public function setEmptyHtml(string $html): static
    {
        $this->empty = $html;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmptyHtml(): string
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
    public function addItem(string $icon, string $message, string $url, string $class = ''): static
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
    public function addItemObject(DropDownNoticeItem $cItem): static
    {
        $this->items[] = $cItem;

        return $this;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return Twig::render('@GCMenu/drop_down_notices.twig', [
            'id'    => $this->id,
            'items' => $this->items,
            'empty' => $this->empty,
        ]);
    }
}
