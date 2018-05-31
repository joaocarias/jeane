<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit30438ad5743075fcbb21be6bce017a9e
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Lib\\' => 4,
            'Layout\\' => 7,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Lib\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib',
        ),
        'Layout\\' => 
        array (
            0 => __DIR__ . '/../..' . '/layout',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit30438ad5743075fcbb21be6bce017a9e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit30438ad5743075fcbb21be6bce017a9e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}