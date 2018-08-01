<?php

/*
 * This file is part of the e-satisfaction WordPress plugin.
 *
 * (c) e-satisfaction Developers <tech@e-satisfaction.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__ . '/../Support/Helpers/Esatisfaction_ViewHelper.php';

/**
 * Class Esatisfaction_Admin
 */
class Esatisfaction_Admin
{
    /**
     * Create menu on admin panel
     */
    public static function createMenu()
    {
        add_submenu_page(
            'options-general.php',
            'E-satisfaction Settings',
            'E-satisfaction',
            'manage_options',
            'esatisfaction_plugin_settings',
            ['Esatisfaction_Admin', 'settingsPage']
        );
    }

    /**
     * Build admin settings page
     */
    public static function settingsPage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['esatisfaction_submit']) {
            // Get all data
            $esatisfactionData = $_POST['esatisfaction'];
            foreach ($esatisfactionData as $key => $value) {
                update_option(sprintf('esatisfaction_%s', $key), $value);
            }
        }

        // Echo settings page view
        Esatisfaction_ViewHelper::echoView('admin/settings', [
            // Header
            'header' => __('E-satisfaction Settings', 'e-satisfaction'),
            // Values
            'application_id' => esc_attr(get_option('esatisfaction_application_id')),
            'checkout_questionnaire_id' => esc_attr(get_option('esatisfaction_checkout_questionnaire_id')),
            // Submit button
            'button_submit' => get_submit_button('Save Settings', 'primary', 'esatisfaction_submit'),
        ]);
    }
}
