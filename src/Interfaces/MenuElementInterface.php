<?php
namespace GCWorld\Menu\Interfaces;
/**
 * Interface MenuElementInterface
 */
interface MenuElementInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void;

    /**
     * @return string
     */
    public function render(): string;
}