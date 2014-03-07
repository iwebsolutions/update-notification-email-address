<?php
/**
 * Background Update Notification Email Address
 *
 * Change the email address update notifications are sent to following an
 * automatic background update.
 *
 * @package Background_Update_Notification_Email_Address
 * @author Phil Wylie <phil@iweb.co.uk>
 * @license GPL-2.0+
 * @link http://wordpress.org/plugins/background-update-notification-email-address/
 * @copyright 2014 Interactive Web Solutions Ltd
 *
 * @wordpress-plugin
 * Plugin Name: Background Update Notification Email Address
 * Plugin URI: http://wordpress.org/plugins/background-update-notification-email-address/
 * Description: Change the email address update notifications are sent to following an automatic background update.
 * Version: 1.0.3
 * Author: Interactive Web Solutions Ltd
 * Author URI: http://www.iwebsolutions.co.uk/
 * Text Domain: update-notification-email-address
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-update-notification-email-address.php' );
add_action( 'plugins_loaded', array( 'Background_Update_Notification_Email_Address', 'get_instance' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/

if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {

	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-update-notification-email-address-admin.php' );
	add_action( 'plugins_loaded', array( 'Background_Update_Notification_Email_Address_Admin', 'get_instance' ) );

}