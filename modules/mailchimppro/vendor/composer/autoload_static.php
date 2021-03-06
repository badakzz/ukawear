<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita9333bdbd81d438180c7ba5675b72fd7
{
    public static $files = array (
        'd4b3877d06f9b76941adbfe5d3cb2fbf' => __DIR__ . '/../..' . '/src/LinkHelper.php',
        'b230e1fbf7ff4907477dbbf4766a9d49' => __DIR__ . '/../..' . '/src/MailchimpProConfig.php',
    );

    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'DrewM\\MailChimp\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'DrewM\\MailChimp\\' => 
        array (
            0 => __DIR__ . '/..' . '/drewm/mailchimp-api/src',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/src',
    );

    public static $prefixesPsr0 = array (
        'J' => 
        array (
            'JasonGrimes' => 
            array (
                0 => __DIR__ . '/..' . '/jasongrimes/paginator/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita9333bdbd81d438180c7ba5675b72fd7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita9333bdbd81d438180c7ba5675b72fd7::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInita9333bdbd81d438180c7ba5675b72fd7::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInita9333bdbd81d438180c7ba5675b72fd7::$prefixesPsr0;
            $loader->classMap = ComposerStaticInita9333bdbd81d438180c7ba5675b72fd7::$classMap;

        }, null, ClassLoader::class);
    }
}
