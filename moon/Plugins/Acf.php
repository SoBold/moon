<?php

namespace Moon\Plugins;

class Acf
{
    public static function init(): void
    {
        add_action('acf/init', [__CLASS__, 'addOptionPages']);
    }

    public static function addOptionPages()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Theme General Settings',
                'menu_title' => 'Theme Settings',
                'menu_slug'  => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect'   => false
            ]);
        }
    }
}
