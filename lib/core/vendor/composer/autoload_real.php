<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit4c7181c04c5f3f7968bd4f39d57fd2bf
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit4c7181c04c5f3f7968bd4f39d57fd2bf', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit4c7181c04c5f3f7968bd4f39d57fd2bf', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit4c7181c04c5f3f7968bd4f39d57fd2bf::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
