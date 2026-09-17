<?php

declare(strict_types=1);

namespace GCWorld\Menu\Tests\PanelElements;

use GCWorld\Menu\DropDownNormal;
use GCWorld\Menu\DropDownWide;
use LogicException;
use PHPUnit\Framework\TestCase;

final class LinkTest extends TestCase
{
    public function testLinkRendersConfiguredButtonBehavior(): void
    {
        $link = (new DropDownNormal('account'))
            ->addPanel('main', 'Main')
            ->addBlock('actions', 'Actions')
            ->addLink('profile')
            ->setName('Profile')
            ->setUrl('/profile')
            ->setClass('success')
            ->setClick('openProfile();')
            ->setNewWindow();

        $html = $link->returnButton();

        self::assertStringContainsString('href="/profile"', $html);
        self::assertStringContainsString('btn-success', $html);
        self::assertStringContainsString('onclick="openProfile();"', $html);
        self::assertStringContainsString('target="_blank"', $html);
        self::assertStringContainsString('>Profile</a>', $html);
    }

    public function testLoaderRendersWidePanelSwitchingJavascript(): void
    {
        $link = (new DropDownWide('account'))
            ->addPanel('main', 'Main')
            ->addBlock('actions', 'Actions')
            ->addLink('settings')
            ->setName('Settings')
            ->setLoader('settings-panel');

        $html = $link->returnButton();

        self::assertStringContainsString('.WIDE_PANEL_CLASS_account:not(#MENU_settings-panel)', $html);
        self::assertStringContainsString("$('#MENU_settings-panel').fadeIn('fast')", $html);
    }

    public function testLoaderRejectsNormalDropdown(): void
    {
        $link = (new DropDownNormal('account'))
            ->addPanel('main', 'Main')
            ->addBlock('actions', 'Actions')
            ->addLink('settings');

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('only supported by wide dropdowns');

        $link->setLoader('settings-panel');
    }
}
