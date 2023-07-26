<?php

namespace Moon;

class Moon
{
    public static function init(): void
    {
        \Moon\Component::init();

        //* Wordpress
        \Moon\Wordpress\Head::init();
        \Moon\Wordpress\Menus::init();
        \Moon\Wordpress\Scripts::init();
        \Moon\Wordpress\Images::init();

        if (\is_admin()) {
            \Moon\Blocks::init();
            \Moon\Wordpress\Admin::init();
            \Moon\Wordpress\BlockEditor::init();
            \Moon\Wordpress\Cleanup::init();
            \Moon\Wordpress\Settings::init();
            \Moon\Wordpress\MimeTypes::init();
        }

        //* Plugins
        \Moon\Plugins\Acf::init();
        \Moon\Plugins\Woocommerce::init();
    }
}
