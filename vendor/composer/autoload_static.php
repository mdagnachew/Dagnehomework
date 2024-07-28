<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit03dd13b1b6718320208ab1bc7a9705c4
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit03dd13b1b6718320208ab1bc7a9705c4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit03dd13b1b6718320208ab1bc7a9705c4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit03dd13b1b6718320208ab1bc7a9705c4::$classMap;

        }, null, ClassLoader::class);
    }
}
