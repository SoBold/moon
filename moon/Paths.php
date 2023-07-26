<?php

namespace Moon;

class Paths
{
    public static function extract(string $path): string
    {
        $pathParts = explode('/', $path);
        $manifest = self::decodedContent('./dist/manifest.json');

        foreach ($pathParts as $part) {
            $manifest = $manifest[$part] ?? null;
            if (is_null($manifest)) {
                return '';
            }
        }

        if (empty($manifest)) {
            return '';
        }

        return $manifest;
    }

    public static function decodedContent(string $asset): array
    {
        $content = self::content($asset);

        if (empty($content)) {
            return [];
        }

        return json_decode($content, true);
    }

    public static function content(string $asset): string
    {
        $path = self::getPath($asset);

        if (empty($path) || !file_exists($path)) {
            return '';
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            return '';
        }

        return trim($contents);
    }

    public static function resolve(string $path): string
    {
        $path = ltrim($path, '/');

        $childPath = \get_stylesheet_directory() . '/dist/' . $path;
        $childPath = self::preparePath($childPath);
        if (file_exists($childPath)) {
            return $childPath;
        }

        $parentPath = \get_template_directory() . '/dist/' . $path;
        $parentPath = self::preparePath($parentPath);

        return $parentPath;
    }

    public static function getUrl(string $url = '', bool $useManifest = false): string
    {
        if ($useManifest === true) {
            $url = self::extract($url);
        }

        if (empty($url)) {
            return '';
        }

        return \get_theme_file_uri(self::getPath($url, true));
    }

    public static function getPath(string $path = '', bool $relative = false): string
    {
        if ($relative) {
            return $path;
        }

        return \get_theme_file_path($path);
    }

    public static function getPathWithGlob(string $path): array
    {
        $path = ltrim($path, '/');
        $paths = [];

        $childPath = \get_stylesheet_directory() . '/' . $path;
        $paths = glob($childPath);

        $parentPath = \get_template_directory() . '/' . $path;
        $parentPaths = glob($parentPath);

        $paths = array_merge($parentPaths, $paths);

        return $paths;
    }

    public static function extractPath(string $path): string
    {
        $reg = '/(^.*)(components)(\S*)$/m';
        $sub = '$2$3/$3';
        $path = preg_replace($reg, $sub, $path);

        return $path;
    }

    private static function preparePath(string $path): string
    {
        if (is_dir($path)) {
            $path .= '/index.php';
        }
        if (empty(pathinfo($path, PATHINFO_EXTENSION))) {
            $path .= '.php';
        }
        return $path;
    }
}
