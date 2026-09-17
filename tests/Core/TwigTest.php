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
}
