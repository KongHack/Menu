<?php

declare(strict_types=1);

namespace GCWorld\Menu\Tests\Components;

use GCWorld\Menu\Components\DropDownNoticeItem;
use PHPUnit\Framework\TestCase;

final class DropDownNoticeItemTest extends TestCase
{
    public function testConfiguredItemRendersExpectedMarkup(): void
    {
        $item = (new DropDownNoticeItem())
            ->setIcon('<i class="icon"></i>')
            ->setClass('notice-info')
            ->setMessage('A message')
            ->setUrl('/notices/1')
            ->setHoverText('Open "message"');
        $item->setData('notice-id', '1&2');

        $html = $item->getHtml();

        self::assertStringContainsString(
            '<li class="notification-li tool_button" title="Open &quot;message&quot;">',
            $html,
        );
        self::assertStringNotContainsString('class=""', $html);
        self::assertStringContainsString('class="notification-entry notice-info"', $html);
        self::assertStringContainsString('href="/notices/1"', $html);
        self::assertStringContainsString('data-notice-id="1&amp;2"', $html);
        self::assertStringContainsString('<i class="icon"></i>', $html);
        self::assertStringContainsString('A message', $html);
    }
}
