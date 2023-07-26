<?php

namespace Moon\Wordpress;

class PageObject
{
    public static function get(): object
    {
        global $wp_query;
        if ($wp_query->is_home()) {
            return \get_post_type_object('post');
        } elseif ($wp_query->is_search()) {
            return $wp_query;
        } elseif ($wp_query->is_404()) {
            return $wp_query;
        } elseif (!empty($wp_query->get_queried_object())) {
            return \get_queried_object();
        }

        return $wp_query;
    }
}
