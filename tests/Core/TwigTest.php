<?php

declare(strict_types=1);

namespace GCWorld\Menu\Tests\Core;

use GCWorld\Menu\Core\Twig;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class TwigTest extends TestCase
{
    public function testMapAllRegistersMenuNamespaceOnFilesystemLoader(): void
    {
        $loader = new FilesystemLoader();
        $twig = new Environment($loader);

        Twig::mapAll($twig);

        self::assertSame(
            [dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'twig'],
            $loader->getPaths(Twig::TWIG_NAMESPACE),
        );
    }

    public function testStandaloneEnvironmentUsesPackagedTwigDirectory(): void
    {
        $twig = Twig::get();

        self::assertContains(
            dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'twig',
            Twig::getLoader()->getPaths(),
        );
        self::assertNotEmpty(
            Twig::getLoader()->getPaths(Twig::TWIG_NAMESPACE),
        );
        self::assertSame(Twig::getLoader(), $twig->getLoader());
    }

    public function testEveryRendererTemplateIsPackaged(): void
    {
        $templateDirectory = dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'twig';
        $templates = [
            'menu.twig',
            'menu_elements.twig',
            'drop_down_normal.twig',
            'drop_down_wide.twig',
            'drop_down_notices.twig',
            'menu_panel.twig',
            'menu_block.twig',
            'components/drop_down_notice_item.twig',
            'panel_elements/link.twig',
        ];

        foreach ($templates as $template) {
            self::assertFileExists($templateDirectory.DIRECTORY_SEPARATOR.$template);
            self::assertSame(
                '@GCMenu/'.$template,
                Twig::get()->load('@GCMenu/'.$template)->getTemplateName(),
            );
        }
    }
}
