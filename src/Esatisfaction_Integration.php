<?php

/*
 * This file is part of the e-satisfaction WordPress plugin.
 *
 * (c) e-satisfaction Developers <tech@e-satisfaction.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__ . '/Support/Helpers/Esatisfaction_ViewHelper.php';

/**
 * Class Esatisfaction_Integration
 */
class Esatisfaction_Integration
{
    /**
     * Attach integration library script on output buffer
     */
    public function initializeIntegration()
    {
        Esatisfaction_ViewHelper::echoView('integration/init', [
            'application_id' => esc_attr(get_option('esatisfaction_application_id')),
        ]);
    }

    /**
     * Attach integration library script on output buffer
     */
    public function attachLibrary()
    {
        Esatisfaction_ViewHelper::echoView('integration/library');
    }

    /**
     * @param string $orderId
     */
    public function attachCheckoutQuestionnaire($orderId)
    {
        // Get user's billing email
        $order = new WC_Order($orderId);

        // Embed code for Checkout Questionnaire
        Esatisfaction_ViewHelper::echoView('integration/checkout', [
            'application_id' => esc_attr(get_option('esatisfaction_application_id')),
            'checkout_questionnaire_id' => esc_attr(get_option('esatisfaction_checkout_questionnaire_id')),
            'order_id' => $order->get_id(),
            'order_date' => $order->get_date_created(),
            'user_email' => $order->get_billing_email(),
        ]);
    }
}
