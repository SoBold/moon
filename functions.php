<?php

/**
 * Moon
 */

if (!file_exists($autoload = __DIR__ . '/vendor/autoload.php')) {
    $err = new \WP_Error('no_composer', 'Composer is not installed and an autoload was not found inside child theme.');
    echo $err->get_error_message();
    exit;
}
require $autoload;

Moon\Moon::init();
