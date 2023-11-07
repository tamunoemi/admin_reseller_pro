<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInite0ae08f724979516636071a7ca1cf7ae
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

        spl_autoload_register(array('ComposerAutoloaderInite0ae08f724979516636071a7ca1cf7ae', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInite0ae08f724979516636071a7ca1cf7ae', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInite0ae08f724979516636071a7ca1cf7ae::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
