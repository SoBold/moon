<?php

namespace Moon\Wordpress;

class Settings
{
    public static function init(): void
    {
        add_action('after_setup_theme', [__CLASS__, 'addThemeSupports']);
        add_action('after_setup_theme', [__CLASS__, 'addContentWidth'], 0);
    }

    public static function addThemeSupports(): void
    {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]);
        add_theme_support('custom-background', apply_filters('_s_custom_background_args', [
            'default-color' => 'ffffff',
            'default-image' => '',
        ]));
        add_theme_support('custom-logo', [
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ]);
    }

    public static function addContentWidth()
    {
        $GLOBALS['content_width'] = 1200;
    }
}
