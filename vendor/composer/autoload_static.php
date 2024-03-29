<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3c1c79d556f52509738fd4249e702bea
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
        'A' => 
        array (
            'Admin\\Quanlybanhang\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
        'Admin\\Quanlybanhang\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit3c1c79d556f52509738fd4249e702bea::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3c1c79d556f52509738fd4249e702bea::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3c1c79d556f52509738fd4249e702bea::$classMap;

        }, null, ClassLoader::class);
    }
}
