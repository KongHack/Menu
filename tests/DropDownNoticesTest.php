<?php

declare(strict_types=1);

namespace GCWorld\Menu\Tests;

use GCWorld\Menu\Components\DropDownNoticeItem;
use GCWorld\Menu\DropDownNotices;
use PHPUnit\Framework\TestCase;

final class DropDownNoticesTest extends TestCase
{
    public function testEmptyDropdownUsesConfiguredContent(): void
    {
        $dropdown = (new DropDownNotices('alerts'))
            ->setEmptyHtml('<strong>Nothing new</strong>');

        self::assertSame(
            '<ul id="alerts_list" class="dropdown-menu notification-dropdown-menu">'.
            '<li><div class="notification-menu-empty"><strong>Nothing new</strong></div></li></ul>',
            $dropdown->render(),
        );
    }

    public function testDropdownRendersSimpleAndObjectItems(): void
    {
        $dropdown = new DropDownNotices('alerts');
        $dropdown->addItem('!', 'First', '/first', 'important');
        $dropdown->addItemObject(
            (new DropDownNoticeItem())
                ->setMessage('Second')
                ->setUrl('/second'),
        );

        $html = $dropdown->render();

        self::assertStringContainsString('id="alerts_list"', $html);
        self::assertStringContainsString('notification-entry important', $html);
        self::assertStringContainsString('First', $html);
        self::assertStringContainsString('Second', $html);
        self::assertStringNotContainsString('notification-menu-empty', $html);
    }
}
