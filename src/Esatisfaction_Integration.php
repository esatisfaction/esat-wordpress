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
    public function attachIntegration()
    {
        // Echo integration library script
        Esatisfaction_ViewHelper::echoView('integration/library', [
            'site_id' => esc_attr(get_option('esatisfaction_site_id')),
        ]);
    }

    /**
     * @param string $orderId
     */
    public function attachCheckoutQuestionnaire($orderId)
    {
        // Get token
        $token = file_get_contents(sprintf('https://www.e-satisfaction.gr/miniquestionnaire/genkey.php?site_auth=%s', esc_attr(get_option('esatisfaction_auth_key'))));

        // Get user's billing email
        $order = new WC_Order($orderId);
        $user_email = $order->get_billing_email();

        // Embed code for Checkout Questionnaire
        Esatisfaction_ViewHelper::echoView('integration/checkout', [
            'token' => $token,
            'order_id' => $orderId,
            'user_email' => $user_email,
        ]);
    }
}
