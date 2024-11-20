<?php
namespace GCWorld\Menu\Core;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

/**
 * Class Twig
 */
class Twig
{
    protected static string $twigNamespace       = 'GCMenu';
    protected static ?Environment     $twig      = null;
    protected static ?LoaderInterface $loader    = null;
    protected static ?string $FCVersion          = null;

    /**
     * @param FilesystemLoader $filesystem
     *
     * @return void
     */
    public static function attachPath(FilesystemLoader $filesystem): void
    {
        $dir = __DIR__.
            DIRECTORY_SEPARATOR.'..'.
            DIRECTORY_SEPARATOR.'..'.
            DIRECTORY_SEPARATOR.'twig';
        $dir = realpath($dir);
        $dir = rtrim($dir,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        $filesystem->addPath($dir, static::$twigNamespace);
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
                'cache'       => self::getTwigDir().DIRECTORY_SEPARATOR.'cache',
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
        return __DIR__.
            DIRECTORY_SEPARATOR.'..'.
            DIRECTORY_SEPARATOR.'..'.
            DIRECTORY_SEPARATOR.'twig';
    }

    /**
     * @param string     $name
     * @param array|null $context
     *
     * @throws SyntaxError
     * @throws LoaderError
     * @throws RuntimeError|\Throwable
     *
     * @return string
     */
    public static function render(string $name, array $context = null): string
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
