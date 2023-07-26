<?php

namespace Moon\Wordpress;

class BlockEditor
{
    public static function init(): void
    {
        \add_action('admin_head', [__CLASS__, 'blockEditorStyle']);
    }

    public static function blockEditorStyle(): void
    {
        echo '<style>.wp-block{max-width:90%;}</style>';
    }
}
