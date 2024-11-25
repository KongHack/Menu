<?php
namespace GCWorld\Menu\Components;

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
    protected array  $data      = [];

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
    protected function getDataString(): string
    {
        if(empty($this->data)) {
            return '';
        }
        $out = '';
        foreach($this->data as $k => $v) {
            $out .= ' data-'.$k.'="'.htmlentities($v).'" ';
        }
        return $out;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        $hover   = '';
        $liClass = 'notification-li';
        if(!empty($this->hoverText)) {
            $hover = $this->hoverText;
            if(str_contains($hover,'"')) {
                $hover = htmlentities($hover);
            }
            $hover    = ' class="" title="'.$hover.'"';
            $liClass .= ' tool_button';
        }

        $html = '<li class="'.$liClass.'"'.$hover.'>';
        $html .= '<a class="notification-entry '.$this->getClass().'" href="'.$this->url.'" '.$this->getDataString().'>';
        $html .= '<span class="notification-icon">'.$this->icon.'</span>';
        $html .= '<span class="notification-message">'.$this->message.'</span>';
        $html .= '</a>';
        $html .= '</li>';

        return $html;
    }
}