<?php

namespace Moon\Wordpress;

class Menus
{
    public static function init(): void
    {
        add_action('after_setup_theme', [__CLASS__, 'addMenus']);
    }

    public static function addMenus(): void
    {
        register_nav_menus([
            'primary' => 'Primary',
        ]);
    }
}
