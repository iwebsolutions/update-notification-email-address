<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package Background_Update_Notification_Email_Address
 * @author Phil Wylie <phil@iweb.co.uk>
 * @license GPL-2.0+
 * @link http://wordpress.org/plugins/background-update-notification-email-address/
 * @copyright 2014 Interactive Web Solutions Ltd
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'update_notification_email_address_options' );