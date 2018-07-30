<?php

/*
Plugin Name: e-satisfaction Web Integration (WooCommerce)
Description: Enable e-satisfaction.com functionality.
Version:     1.0
Author:      e-satisfaction Developers
Author URI:  https://www.e-satisfaction.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: esatisfation-plugin
*/


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the main WooCommerce class.
if (!class_exists('Esatisfaction')) {
    include_once dirname(__FILE__) . '/src/Esatisfaction.php';
}

/**
 * Instantiate e-satisfaction main class
 */
Esatisfaction::instance();
