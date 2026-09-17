<?php
namespace GCWorld\Menu\Components;

use GCWorld\Menu\Core\Twig;

/**
 * Class DropDownNoticeItem
 */
class DropDownNoticeItem
{
    protected string $icon      = '';
    protected string $class     = '';
    protected string $message   = '';
    protected string $url       = '';
    protected string $hoverText = '';
    /** @var array<string,string> */
    protected array $data = [];

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return DropDownNoticeItem
     */
    public function setIcon(string $icon): DropDownNoticeItem
    {
        $this->icon = $icon;

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
     * @param string $class
     * @return DropDownNoticeItem
     */
    public function setClass(string $class): DropDownNoticeItem
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return DropDownNoticeItem
     */
    public function setMessage(string $message): DropDownNoticeItem
    {
        $this->message = $message;

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
     * @param string $url
     * @return DropDownNoticeItem
     */
    public function setUrl(string $url): DropDownNoticeItem
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getHoverText(): string
    {
        return $this->hoverText;
    }

    /**
     * @param string $hoverText
     * @return DropDownNoticeItem
     */
    public function setHoverText(string $hoverText): DropDownNoticeItem
    {
        $this->hoverText = $hoverText;

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setData(string $key, string $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return Twig::render('@GCMenu/components/drop_down_notice_item.twig', [
            'icon'       => $this->icon,
            'class'      => $this->class,
            'message'    => $this->message,
            'url'        => $this->url,
            'hover_text' => $this->hoverText,
            'data'       => $this->data,
        ]);
    }
}
