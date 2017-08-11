<?php

/*
Plugin Name: E satisfaction Integration
Plugin URI:  http://www.digitalworks.gr
Description: Enable e-satisfaction.com functionality.
Version:     0.1
Author:      Giannis Kipouros
Author URI:  http://www.digitalworks.gr
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: e-satisfation-plugin
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action('admin_menu', 'e_satisfaction_plugin_create_menu');

function e_satisfaction_plugin_create_menu() {
    add_submenu_page(
        'options-general.php',
        'E-Satisfaction Settings',
        'E-Satisfaction Settings',
        'manage_options',
        'e_satisfaction_plugin_settings',
        'e_satisfaction_plugin_settings_page' );
}


add_action('wp_footer', 'e_satisfaction_library_script_footer', 20);

function e_satisfaction_plugin_settings_page() {

  if ($_POST['e_satisfaction_submit']) {

    $data['site_id']            = sanitize_text_field($_POST['site_id']);
    $data['auth_key']           = sanitize_text_field($_POST['auth_key']);
    $data['public_api_key']     = sanitize_text_field($_POST['public_api_key']);
    $data['private_api_key']    = sanitize_text_field($_POST['private_api_key']);

    if ($data['site_id'] != "") {
      update_option('e_satisfaction_site_id', $data['site_id']);
    }

    if ($data['auth_key'] != "") {
      update_option('e_satisfaction_auth_key', $data['auth_key']);
    }

    if ($data['public_api_key'] != "") {
      update_option('e_satisfaction_public_api_key', $data['public_api_key']);
    }

    if ($data['private_api_key'] != "") {
      update_option('e_satisfaction_private_api_key', $data['private_api_key']);
    }
  }
?>
<div class="wrap">
<h1><?php echo __('E-Satisfaction settings', 'e-satisfaction');?></h1>

<form method="post" >
  <table class="form-table">
      <tr valign="top">
        <th scope="row"><?php echo __('SITE_ID', 'e-satisfaction');?>:</th>
        <td><input type="number" name="site_id" class="regular-text" value="<?php echo esc_attr( get_option('e_satisfaction_site_id') ); ?>" /></td>
      </tr>

      <tr valign="top">
        <th scope="row"><?php echo __('AUTH_KEY', 'e-satisfaction');?>:</th>
        <td><input type="text" name="auth_key" class="regular-text" value="<?php echo esc_attr( get_option('e_satisfaction_auth_key') ); ?>" /></td>
      </tr>

      <tr valign="top">
        <th scope="row"><?php echo __('PUBLIC_API_KEY', 'e-satisfaction');?>:</th>
        <td><input type="text" name="public_api_key" class="regular-text" value="<?php echo esc_attr( get_option('e_satisfaction_public_api_key') ); ?>" /></td>
      </tr>

      <tr valign="top">
        <th scope="row"><?php echo __('PRIVATE_API_KEY', 'e-satisfaction');?>:</th>
        <td><input type="text" name="private_api_key" class="regular-text" value="<?php echo esc_attr( get_option('e_satisfaction_private_api_key') ); ?>" /></td>
      </tr>
  </table>

  <?php submit_button('Save Settings', 'primary', 'e_satisfaction_submit'); ?>

</form>
</div>
<?php }


function e_satisfaction_library_script_footer(){ ?>
<script>
  var _esatisf = _esatisf || [];
  _esatisf.push(['_site','<?php echo esc_attr( get_option('e_satisfaction_site_id') ); ?>']);

  (function() {
   var ef = document.createElement('script');
   ef.type = 'text/javascript';
   ef.async = true;
   ef.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'www.e-satisfaction.gr/min/f=e-satisfaction.js';
   var s = document.getElementsByTagName('script')[0];
   s.parentNode.insertBefore(ef, s);
  } )();
</script>
<?php } ?>


<?php

add_action('woocommerce_thankyou', 'e_satisfaction_checkout_questionnaire', 1, 1);

function e_satisfaction_checkout_questionnaire( $order_id ) {
  $token = file_get_contents(
    'https://www.e-satisfaction.gr/miniquestionnaire/genkey.php?site_auth='.esc_attr(get_option('e_satisfaction_auth_key'))
  );
  $order = new WC_Order( $order_id );
  $user_email = $order->billing_email;
  echo '<div class="esatisf-form"> <!-- here the questionnaire will append --> </div>';
  ?>

  <script>
    var _esatisf = _esatisf || [];
   _esatisf.push(['_responder', '<?php echo $order_id;?>']); //unique identifier of the order
   _esatisf.push(['_token', '<?php echo $token;?>']); //token that is being generated in the beginning of this step
   _esatisf.push(['_email', '<?php echo $user_email;?>']); // e-mail of the customer who made the purchase
   _esatisf.push(['_showQuestionnaire', '.esatisf-form']);
  </script>
  <?
}
?>
