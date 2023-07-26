<?php

namespace Moon\Wordpress;

class Images
{
    public static function init(): void
    {
        if (isset($_ENV) && isset($_ENV['REMOTEURL'])) {
            \add_filter('wp_get_attachment_image_src', [__CLASS__, 'getAttachmentSrc']);
            \add_filter('wp_get_attachment_url', [__CLASS__, 'getAttachmentUrl']);
            \add_filter('wp_calculate_image_srcset', [__CLASS__, 'calculateImageSrcset']);
        }
    }

    public static function getAttachmentSrc($image)
    {
        $image[0] = str_replace($_ENV['LOCALURL'], $_ENV['REMOTEURL'], $image[0]);
        return $image;
    }

    public static function getAttachmentUrl($url)
    {
        return str_replace($_ENV['LOCALURL'], $_ENV['REMOTEURL'], $url);
    }

    public static function calculateImageSrcset($sources)
    {
        foreach ($sources as &$source) {
            $source['url'] = str_replace($_ENV['LOCALURL'], $_ENV['REMOTEURL'], $source['url']);
        }
        return $sources;
    }
}
