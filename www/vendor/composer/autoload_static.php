<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite6b4ea2903eeb587890cc9e93de25680
{
    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/..' . '/lyranetwork/krypton-php-sdk/src',
    );

    public static $prefixesPsr0 = array (
        'L' => 
        array (
            'LyraNetwork' => 
            array (
                0 => __DIR__ . '/../..' . '/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->fallbackDirsPsr4 = ComposerStaticInite6b4ea2903eeb587890cc9e93de25680::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite6b4ea2903eeb587890cc9e93de25680::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}