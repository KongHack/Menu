<?php

declare(strict_types=1);

namespace GCWorld\Menu\Tests;

use GCWorld\Menu\Menu;
use PHPUnit\Framework\TestCase;

final class MenuTest extends TestCase
{
    public function testMenuRendersBrandAndAlignedLinks(): void
    {
        $menu = (new Menu())
            ->setTitle('Example')
            ->setLogo('/logo.svg')
            ->setURL('/home');
        $menu->addLink('dashboard', 'Dashboard', '/dashboard');
        $menu->addLink('help', 'Help', '/help', true, true);

        $html = $menu->returnMenu();

        self::assertStringContainsString('href="/home"', $html);
        self::assertStringContainsString('src="/logo.svg" alt="Example"', $html);
        self::assertStringNotContainsString('gc-navbar-brand', $html);
        self::assertStringContainsString('<ul class="nav navbar-nav">', $html);
        self::assertStringContainsString('<li id="dashboard"><a href="/dashboard"', $html);
        self::assertStringContainsString('<ul class="nav navbar-nav navbar-right">', $html);
        self::assertStringContainsString(
            '<li id="help"><a href="/help" class="no-ajaxy" target="_blank">Help</a></li>',
            $html,
        );
    }

    public function testMenuRendersOptionalNavbarBrandOverlayAsRawMarkup(): void
    {
        $menu = (new Menu())
            ->setTitle('Example')
            ->setLogo('/logo.svg')
            ->setNavbarBrandOverlay('<span class="environment">Test</span>');

        $html = $menu->returnMenu();

        self::assertStringContainsString('<span class="gc-navbar-brand">', $html);
        self::assertStringContainsString(
            '<span class="gc-navbar-brand-overlay"><span class="environment">Test</span></span>',
            $html,
        );
    }

    public function testBlankNavbarBrandOverlayPreservesOriginalBrandMarkup(): void
    {
        $menu = (new Menu())
            ->setLogo('/logo.svg')
            ->setNavbarBrandOverlay('');

        $html = $menu->returnMenu();

        self::assertStringNotContainsString('gc-navbar-brand', $html);
        self::assertMatchesRegularExpression(
            '/<a class="navbar-brand"[^>]*>\s*<img src="\/logo\.svg" alt="">\s*<\/a>/',
            $html,
        );
    }

    public function testGoogleSearchTakesPrecedenceOverCustomSearchForm(): void
    {
        $menu = new Menu();
        $menu->googleSearchURL = '/search';
        $menu->searchForm = '<form id="custom-search"></form>';

        $html = $menu->returnMenu();

        self::assertStringContainsString('action="/search"', $html);
        self::assertStringNotContainsString('custom-search', $html);
    }

    public function testCustomHtmlElementsRemainDeveloperControlledMarkup(): void
    {
        $menu = new Menu();
        $menu->addHTML('custom', '<li id="custom">Custom</li>');
        $menu->addDropDownHTML('tools', 'Tools')
            ->setHTML('<strong>Tool content</strong>');

        $html = $menu->renderElements();

        self::assertStringContainsString('<li id="custom">Custom</li>', $html);
        self::assertStringContainsString('<strong>Tool content</strong>', $html);
    }

    public function testEveryDropdownTypeRendersThroughElementTemplate(): void
    {
        $menu = new Menu();
        $menu->addDropDown('normal', 'Normal')
            ->addPanel('normal-panel', 'Normal panel')
            ->addBlock('normal-block', 'Normal block')
            ->setHTML('Normal content');

        $wide = $menu->addDropDownWide('wide', 'Wide');
        $wide->setDefault('wide-panel');
        $wide->addPanel('wide-panel', 'Wide panel')
            ->addBlock('wide-block', 'Wide block')
            ->setHTML('Wide content');

        $menu->addDropDownNotice('notices', 'Notices')
            ->addItem('!', 'Notice content', '/notice');

        $html = $menu->renderElements();

        self::assertStringContainsString('<li class="dropdown" id="normal">', $html);
        self::assertStringContainsString('Normal content', $html);
        self::assertStringContainsString('<li class="dropdown yamm-fw" id="wide">', $html);
        self::assertStringContainsString('Wide content', $html);
        self::assertStringContainsString('<li class="dropdown" id="notices">', $html);
        self::assertStringContainsString('Notice content', $html);
    }
}
