<?php
namespace GCWorld\Menu\Notifications;

use Exception;
use GCWorld\Menu\DropDownNotices;

class NotificationBank
{
    /** @var array<string,DropDownNotices> */
    protected array $menus = [];

    /**
     * @param string $id
     * @param DropDownNotices $menu
     * @return void
     */
    protected function addMenu(string $id, DropDownNotices $menu): void
    {
        $this->menus[$id] = $menu;
    }

    /**
     * @param string $id
     * @return DropDownNotices
     * @throws Exception
     */
    protected function getMenu(string $id): DropDownNotices
    {
        if(!isset($this->menus[$id])) {
            throw new Exception('Menu Not Found');
        }

        return $this->menus[$id];
    }


}