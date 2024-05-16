<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6bd92bf2520efbc82ee4efb836e4f763
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Devweb\\PersonalRecord\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Devweb\\PersonalRecord\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6bd92bf2520efbc82ee4efb836e4f763::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6bd92bf2520efbc82ee4efb836e4f763::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6bd92bf2520efbc82ee4efb836e4f763::$classMap;

        }, null, ClassLoader::class);
    }
}
