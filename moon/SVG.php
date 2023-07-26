<?php

namespace Moon;

use Moon\Paths;

class SVG
{
    public static function get(string $name, array $args = []): string
    {
        $svg = '';
        $args = array_merge([
            'name'        => $name,
            'width'       => 0,
            'height'      => 0,
            'title'       => '',
            'wrap'        => false,
            'description' => '',
        ], $args);

        if (self::isUrl($args['name'])) {
            $svgPath = $args['name'];
        } elseif (self::isStatic($args['name'])) {
            //* Search in static folder
            $svgPath = self::staticPath($args['name']);
        } elseif (self::isPath($args['name'])) {
            $svgPath = self::path($args['name']);
        } else {
            $svgPath = $args['name'];
        }

        if (substr($svgPath, -4, 4) !== '.svg') {
            return $svg;
        }

        if (!isset($_ENV)) {
            if (!file_exists($svgPath)) {
                return $svg;
            }
        }

        $uniqueID = uniqid();

        $doc = new \DOMDocument();
        $doc->loadXML(file_get_contents($svgPath));
        $doc->documentElement->setAttribute('role', 'img');
        if ($args['title'] !== '') {
            $labelled = [];
            $labelled[] = 'title-' . $uniqueID;

            $title = $doc->createElement('title', $args['title']);
            $title->setAttribute('id', 'title-' . $uniqueID);

            $doc->firstChild->appendChild($title);

            if ($args['description'] !== '') {
                $labelled[] = 'description-' . $uniqueID;

                $description = $doc->createElement('description', $args['description']);
                $description->setAttribute('id', 'description-' . $uniqueID);

                $doc->firstChild->appendChild($description);
            }

            $doc->documentElement->setAttribute('aria-labelledby', implode(' ', $labelled));
        } else {
            $doc->documentElement->setAttribute('aria-hidden', 'true');
        }

        if (empty($args['width']) || empty($args['height'])) {
            $svgInfo = self::info($doc);
        }

        if (!empty($args['width'])) {
            $doc->documentElement->setAttribute('width', $args['width']);
        } elseif (!empty($svgInfo['w'])) {
            $doc->documentElement->setAttribute('width', $svgInfo['w']);
        }

        if (!empty($args['height'])) {
            $doc->documentElement->setAttribute('height', $args['height']);
        } elseif (!empty($svgInfo['h'])) {
            $doc->documentElement->setAttribute('height', $svgInfo['h']);
        }

        $svg = $doc->saveXML($doc->documentElement);

        if ($args['wrap'] === true) {
            $svg = '<span class="svg-asset svg-asset--' . esc_attr($args['name']) . '">' . $svg . '</span>';
        }

        return $svg;
    }

    public static function isUrl(string $path): bool
    {
        $urlReg = '/^(?:https?):\/\/[^\s\/$.?#].[^\s]*$/i';
        return preg_match($urlReg, $path) === 1;
    }

    public static function isStatic(string $path): bool
    {
        return strpos($path, '/') === false && strpos($path, '.svg') !== false;
    }

    public static function staticPath(string $path): string
    {
        return \get_stylesheet_directory() . '/static/' . $path;
    }

    public static function isPath(string $path): string
    {
        $urlReg = '/^\/([a-zA-Z0-9-]+\/)*([a-zA-Z0-9-]+)\.(svg)$/i';
        return preg_match($urlReg, $path) === 1;
    }

    public static function path(string $path): string
    {
        return isset($_ENV) && isset($_ENV['REMOTEURL']) ? $_ENV['REMOTEURL'] . $path : ABSPATH . $path;
    }

    public static function attrs($svg, array $attrNames): array
    {
        $attrs = [];

        if (gettype($svg) === 'string' && file_exists($svg)) {
            $doc = new \DOMDocument();
            $doc->loadXML(file_get_contents($svg));
        } else {
            $doc = $svg;
        }

        if (gettype($doc) === 'object' && get_class($doc) === 'DOMDocument') {
            foreach ($attrNames as $attrName) {
                $attrs[$attrName] = $doc->documentElement->getAttribute($attrName);
            }
        }

        return $attrs;
    }


    public static function info($svg): array
    {
        $info = [
            'w' => 'auto',
            'h' => 'auto',
        ];
        $attrs = self::attrs($svg, ['width', 'height', 'viewBox']);

        if (empty($attrs['width']) || empty($attrs['height'])) {
            if (!empty($attrs['viewBox'])) {
                $viewboxAttrParts = explode(' ', $attrs['viewBox']);
            }
        }

        if (!empty($attrs['width'])) {
            $info['w'] = $attrs['width'];
        } elseif (!empty($viewboxAttrParts[2])) {
            $info['w'] = $viewboxAttrParts[2];
        }
        if (!empty($attrs['height'])) {
            $info['h'] = $attrs['height'];
        } elseif (!empty($viewboxAttrParts[3])) {
            $info['h'] = $viewboxAttrParts[3];
        }

        return $info;
    }
}
