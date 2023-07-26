<?php

namespace Moon\WordPress;

class MimeTypes
{
    public static function init(): void
    {
        \add_filter('upload_mimes', [__CLASS__, 'addMimes']);
    }

    public static function addMimes(array $mime_types = []): array
    {
        $mimeTypes = [
            'svg' => 'image/svg+xml',
        ];

        foreach ($mimeTypes as $key => $value) {
            $mime_types[$key] = $value;
        }
        return $mime_types;
    }
}
