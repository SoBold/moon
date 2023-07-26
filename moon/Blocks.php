<?php

namespace Moon;

class Blocks
{
    public static function init(): void
    {
        \add_filter('allowed_block_types_all', [__CLASS__, 'resetBlocks']);
    }

    public static function resetBlocks($allowedBlocks)
    {
        $blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();
        $acfBlocks = [];
        foreach ($blocks as $blockName => $block) {
            if (\str_contains($blockName, 'acf/')) {
                $acfBlocks[] = $blockName;
            }
        }

        return $acfBlocks;
    }
}
