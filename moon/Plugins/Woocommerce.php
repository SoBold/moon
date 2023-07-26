<?php

namespace Moon\Plugins;

class Woocommerce
{
    public static function init(): void
    {
        add_action('after_setup_theme', [__CLASS__, 'setup']);
        add_filter('body_class', [__CLASS__, 'woocommerceActiveBodyClass']);
        add_filter('loop_shop_per_page', [__CLASS__, 'woocommerceProductsPerPage']);
        add_filter('woocommerce_product_thumbnails_columns', [__CLASS__, 'woocommerceThumbnailColumns']);
        add_filter('loop_shop_columns', [__CLASS__, 'woocommerceLoopColumns']);
        add_filter('woocommerce_output_related_products_args', [__CLASS__, 'woocommerceRelatedProductsArgs']);
    }

    public static function setup()
    {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }

    public static function woocommerceActiveBodyClass($classes)
    {
        $classes[] = 'woocommerce-active';
        return $classes;
    }

    public static function woocommerceProductsPerPage()
    {
        return 12;
    }

    public static function woocommerceThumbnailColumns()
    {
        return 4;
    }

    public static function woocommerceLoopColumns()
    {
        return 3;
    }

    public static function woocommerceRelatedProductsArgs($args)
    {
        $defaults = [
            'posts_per_page' => 3,
            'columns'        => 3,
        ];

        $args = wp_parse_args($defaults, $args);

        return $args;
    }
}
