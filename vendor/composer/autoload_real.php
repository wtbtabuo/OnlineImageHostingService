<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbf774f430beb1b3694a91ef24d9d5958
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

        spl_autoload_register(array('ComposerAutoloaderInitbf774f430beb1b3694a91ef24d9d5958', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitbf774f430beb1b3694a91ef24d9d5958', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitbf774f430beb1b3694a91ef24d9d5958::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
