<?php

namespace Moon\Wordpress;

class Scripts
{
    private static $jquerySrc = 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js';

    public static function init(): void
    {
        \add_action('wp_enqueue_scripts', [__CLASS__, 'enqueueScripts']);

        \add_action('wp_default_scripts', [__CLASS__, 'removejQueryMigrate'], 10);
        \add_action('wp_default_scripts', [__CLASS__, 'replacejQueryCore'], 11);
        \add_action('wp_default_scripts', [__CLASS__, 'movejQuery'], 12);

        \add_filter('style_loader_src', [__CLASS__, 'removeVersion'], 10, 2);
        \add_filter('script_loader_src', [__CLASS__, 'removeVersion'], 10, 2);
    }

    public static function enqueueScripts(): void
    {
        \wp_enqueue_style('style', get_stylesheet_uri());
        \wp_enqueue_style('normalize', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css');

        \wp_enqueue_style(
            'parentMain.css',
            \get_parent_theme_file_uri('dist/main.css'),
            [],
            false
        );

        \wp_enqueue_style(
            'main.css',
            \Moon\Paths::getUrl('main.css', true),
            [],
            false
        );

        \wp_enqueue_script(
            'parentApp.js',
            \get_parent_theme_file_uri('dist/app.js'),
            ['jquery'],
            false
        );

        \wp_enqueue_script(
            'app.js',
            \Moon\Paths::getUrl('app.js', true),
            ['jquery', 'parentApp.js'],
            false
        );
    }

    public static function removeVersion(string $src): string
    {
        if (strpos($src, '?ver=')) {
            $src = \remove_query_arg('ver', $src);
        }

        return $src;
    }

    public static function movejQuery($scripts): void
    {
        if (\is_admin()) {
            return;
        }

        $scripts->add_data('jquery', 'group', 1);
        $scripts->add_data('jquery-core', 'group', 1);
    }

    public static function removejQueryMigrate($scripts): void
    {
        if (\is_admin()) {
            return;
        }

        $scripts->remove('jquery');
        $scripts->add('jquery', false, ['jquery-core']);
    }

    public static function replacejQueryCore($scripts): void
    {
        if (\is_admin()) {
            return;
        }

        $scripts->remove('jquery-core');
        $scripts->add('jquery-core', self::$jquerySrc);
    }
}
