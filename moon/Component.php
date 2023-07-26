<?php

namespace Moon;

class Component
{
    public static function init(): void
    {
        \add_action('init', [__CLASS__, 'registerBlocks']);
        \add_action('init', [__CLASS__, 'loadFunctions']);
        \add_action('init', [__CLASS__, 'loadHooks']);
        \add_filter('moon/components/toggle', [__CLASS__, 'toggleComponent']);
        \add_filter('moon/components/attrs', [__CLASS__, 'parseExtraAttributes']);
    }

    public static function render(string $path, $args = []): string
    {
        $filterPath = explode('/', $path);
        $filterPath = $filterPath[0] . '/' . end($filterPath);

        $args = \apply_filters('moon/' . $filterPath, $args);
        $args = \apply_filters('moon/components/toggle', $args);
        $args = \apply_filters('moon/components/attrs', $args);

        if ($args === null) {
            return '';
        }

        $path = \Moon\Paths::resolve($path);
        ob_start();
        require $path;
        return ob_get_clean();
    }

    private static function require(array $files): void
    {
        foreach ($files as $key => $file) {
            require_once $file;
        }
    }

    public static function loadFunctions(): void
    {
        self::require(
            \Moon\Paths::getPathWithGlob('dist/*/*/functions.php')
        );
    }

    public static function loadHooks(): void
    {
        self::require(
            \Moon\Paths::getPathWithGlob('dist/*/*/hooks.php')
        );
    }

    public static function registerBlocks()
    {
        $blocks = \Moon\Paths::getPathWithGlob('dist/*/*/block.json');
        foreach ($blocks as $key => $file) {
            register_block_type($file);
        }
    }

    public static function renderBlocks($block)
    {
        $path = \Moon\Paths::extractPath($block['path']);
        $args = \Moon\Component::getArgs($block, get_fields());

        echo \Moon\Component::render($path, $args);
    }

    public static function getArgs(array $block, $fields): array
    {
        $args = is_array($fields) ? $fields : [];

        if (!empty($block['anchor'])) {
            $args['anchor'] = $block['anchor'];
        }

        return $args;
    }

    public static function toggleComponent(array $args): ?array
    {
        if (isset($args['toggle'])) {
            if (!$args['toggle']) {
                $args = null;
            }
        } else {
            $args['toggle'] = true;
        }

        return $args;
    }

    public static function parseExtraAttributes(array $args): ?array
    {
        if (isset($args['attrs'])) {
            $attrsString = '';
            foreach ($args['attrs'] as $key => $value) {
                if (is_array($value)) {
                    $value = implode(' ', $value);
                }
                $attrsString .= $value !== '' ? "$key=\"$value\" " : "$key ";
                $args['attrsString'] = $attrsString;
            }
        }

        return $args;
    }
}
