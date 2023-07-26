<?php

namespace Moon;

class Moon
{
    public static function init(): void
    {
        \Moon\Blocks::init();
        \Moon\Component::init();

        //* Wordpress
        \Moon\Wordpress\Settings::init();
        \Moon\Wordpress\Head::init();
        \Moon\Wordpress\Admin::init();
        \Moon\Wordpress\Cleanup::init();
        \Moon\Wordpress\Menus::init();
        \Moon\Wordpress\Scripts::init();
        \Moon\Wordpress\Images::init();
        \Moon\Wordpress\MimeTypes::init();
        \Moon\Wordpress\BlockEditor::init();

        //* Plugins
        \Moon\Plugins\Acf::init();
        \Moon\Plugins\Woocommerce::init();
    }
}
