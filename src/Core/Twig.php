<?php
namespace GCWorld\Menu\Core;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * Class Twig
 */
class Twig
{
    public const TWIG_NAMESPACE = 'GCMenu';

    protected static ?Environment $twig = null;
    protected static ?FilesystemLoader $loader = null;

    /**
     * @param FilesystemLoader $filesystem
     *
     * @return void
     */
    public static function attachPath(FilesystemLoader $filesystem): void
    {
        $filesystem->addPath(self::getTwigDir(), self::TWIG_NAMESPACE);
    }

    /**
     * @param Environment $environment
     * @return void
     */
    public static function mapAll(Environment $environment): void
    {
        $loader = $environment->getLoader();
        if ($loader instanceof FilesystemLoader) {
            self::attachPath($loader);
        }
    }

    /**
     * @return Environment
     */
    public static function get(): Environment
    {
        if (null == self::$twig) {
            $loader     = self::getLoader();
            $twig       = new Environment($loader, [
                'auto_reload' => true,
            ]);
            self::mapAll($twig);
            self::$twig = $twig;
        }

        return self::$twig;
    }

    /**
     * @return FilesystemLoader
     */
    public static function getLoader(): FilesystemLoader
    {
        if (null == self::$loader) {
            $loader       = new FilesystemLoader(self::getTwigDir());
            self::$loader = $loader;
        }

        return self::$loader;
    }

    /**
     * @return string
     */
    protected static function getTwigDir(): string
    {
        $directory = dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'twig';

        if (!is_dir($directory)) {
            throw new \RuntimeException('Menu Twig directory not found: '.$directory);
        }

        return $directory;
    }

    /**
     * @param string     $name
     * @param array<string,mixed>|null $context
     *
     * @throws SyntaxError
     * @throws LoaderError
     * @throws RuntimeError|\Throwable
     *
     * @return string
     */
    public static function render(string $name, ?array $context = null): string
    {
        try {
            if (null == $context) {
                return self::get()->render($name);
            }

            return self::get()->render($name, $context);
        } catch (SyntaxError|LoaderError $e) {
            if(function_exists('d')) {
                d($e);
            }

            throw $e;
        } catch (RuntimeError $e) {
            $previous = $e->getPrevious();
            if (\is_object($previous)) {
                throw $previous;
            }

            throw $e;
        }
    }
}
