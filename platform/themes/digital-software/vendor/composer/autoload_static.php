<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita7000e1770e9c5d1df0fb3e5c21cb729
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Theme\\DigitalSoftware\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Theme\\DigitalSoftware\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita7000e1770e9c5d1df0fb3e5c21cb729::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita7000e1770e9c5d1df0fb3e5c21cb729::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
