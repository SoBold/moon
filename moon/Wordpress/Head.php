<?php

namespace Moon\Wordpress;

class Head
{
    public static function init(): void
    {
        \add_action('wp_head', [__CLASS__, 'detectJs'], 0);
    }

    public static function detectJs(): void
    {
        echo "<script>(function(html){html.className = " . "html.className.replace(/\bno-js\b/, 'js')})(document.documentElement);</script>\n";
    }
}
