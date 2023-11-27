<?php
namespace GCWorld\Menu;

/**
 * Class DropDownHTML
 */
class DropDownHTML
{
    protected string $html;
    protected string $id;

    /**
     * DropDownHTML constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $html
     * @return void
     */
    public function setHTML(string $html): void
    {
        $this->html = $html;
    }

    /**
     * @return string
     */
    public function getHTML(): string
    {
        return $this->html ?? '';
    }

    /**
     * @return string
     */
    public function getPanelClass(): string
    {
        return 'HTML_PANEL_CLASS_'.$this->id;
    }
}
