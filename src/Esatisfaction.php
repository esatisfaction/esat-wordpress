<?php

defined('ABSPATH') || exit;

require_once __DIR__ . '/Admin/Esatisfaction_Admin.php';
require_once __DIR__ . '/Esatisfaction_Integration.php';

/**
 * Class Esatisfaction
 *
 * e-satisfaction Singleton
 */
final class Esatisfaction
{
    /**
     * @var string
     */
    public $version = '1.0';

    /**
     * @var Esatisfaction
     */
    protected static $instance = null;

    /**
     * @return Esatisfaction
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * WooCommerce Constructor.
     */
    public function __construct()
    {
        $this->initHooks();
    }

    /**
     * Hook into actions and filters
     */
    private function initHooks()
    {
        add_action('admin_menu', ['Esatisfaction_Admin', 'createMenu']);
        add_action('wp_footer', ['Esatisfaction_Integration', 'attachIntegration'], 20);
        add_action('woocommerce_thankyou', ['Esatisfaction_Integration', 'attachCheckoutQuestionnaire'], 1, 1);
    }
}
