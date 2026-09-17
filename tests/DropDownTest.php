<?php

declare(strict_types=1);

namespace GCWorld\Menu\Tests;

use GCWorld\Menu\DropDownNormal;
use GCWorld\Menu\DropDownWide;
use PHPUnit\Framework\TestCase;

final class DropDownTest extends TestCase
{
    public function testNormalDropdownRendersEveryPanelWithoutPanelSwitchingMarkup(): void
    {
        $dropdown = new DropDownNormal('products');
        $dropdown->addPanel('first', 'First')
            ->addBlock('first-block', 'First block')
            ->setHTML('First content');
        $dropdown->addPanel('second', 'Second')
            ->addBlock('second-block', 'Second block')
            ->setHTML('Second content');

        $html = $dropdown->returnPanels();

        self::assertSame(2, substr_count($html, 'NORMAL_PANEL_CLASS_products'));
        self::assertStringContainsString('First content', $html);
        self::assertStringContainsString('Second content', $html);
        self::assertStringNotContainsString('display:none', $html);
        self::assertStringNotContainsString('id="MENU_', $html);
    }

    public function testWideDropdownHidesAllPanelsUntilDefaultIsSelected(): void
    {
        $dropdown = $this->createWideDropdown();

        self::assertSame(2, substr_count($dropdown->returnPanels(), 'style="display:none"'));

        $dropdown->setDefault('second');
        $html = $dropdown->returnPanels();

        self::assertStringContainsString(
            'id="MENU_first" style="display:none"',
            $html,
        );
        self::assertStringContainsString(
            'id="MENU_second" >',
            $html,
        );
    }

    public function testWideDropdownOverrideReplacesPanels(): void
    {
        $dropdown = $this->createWideDropdown();
        $dropdown->setOverrideHtml('<strong>Override</strong>');

        $html = $dropdown->returnPanels();

        self::assertStringContainsString('id="MENU_account"', $html);
        self::assertStringContainsString('<strong>Override</strong>', $html);
        self::assertStringNotContainsString('First content', $html);
    }

    private function createWideDropdown(): DropDownWide
    {
        $dropdown = new DropDownWide('account');
        $dropdown->addPanel('first', 'First')
            ->addBlock('first-block', 'First block')
            ->setHTML('First content');
        $dropdown->addPanel('second', 'Second')
            ->addBlock('second-block', 'Second block')
            ->setHTML('Second content');

        return $dropdown;
    }
}
