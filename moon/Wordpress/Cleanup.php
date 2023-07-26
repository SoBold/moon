<?php

namespace Moon\Wordpress;

class Cleanup
{
    public static function init(): void
    {
        add_action('wp_dashboard_setup', [__CLASS__, 'removeDashboardWidgets']);
    }

    public static function removeDashboardWidgets()
    {
        remove_meta_box('dashboard_primary', 'dashboard', 'side');
        remove_meta_box('dashboard_secondary', 'dashboard', 'side');
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    }
}
