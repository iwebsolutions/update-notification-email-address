<?php
/**
 * Background_Update_Notification_Email_Address
 *
 * @package Background_Update_Notification_Email_Address
 * @author Phil Wylie <phil@iweb.co.uk>
 * @license GPL-2.0+
 * @link http://wordpress.org/plugins/background-update-notification-email-address/
 * @copyright 2014 Interactive Web Solutions Ltd
 */

/**
 * Background_Update_Notification_Email_Address class. This class handles the
 * filtering of WordPress behaviour during a background update.
 *
 * @package Background_Update_Notification_Email_Address
 * @author Phil Wylie <phil@iweb.co.uk>
 */
class Background_Update_Notification_Email_Address {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	const VERSION = '1.0.3';

	/**
	 * Unique identifier for your plugin.
	 *
	 * The variable name is used as the text domain when internationalizing
	 * strings of text. Its value should match the Text Domain file header in
	 * the main plugin file.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $plugin_slug = 'update-notification-email-address';

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by hooking our function to auto_core_update_email.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {

		// Filter the background update notification email.
		add_filter( 'auto_core_update_email', array( $this, 'filter_auto_core_update_email' ), 1 );

	}

	/**
	 * Return the plugin slug.
	 *
	 * @since 1.0.0
	 *
	 * @return Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Filter the background update notification email
	 *
	 * @since 1.0.0
	 *
	 * @param array $email Array of email arguments that will be passed to wp_mail().
	 * @return array Modified array containing the new email address.
	 */
	public function filter_auto_core_update_email( $email ) {

		// Get plugin settings.
		$options = get_option( 'update_notification_email_address_options' );

		// If an email address has been set, override the WordPress default.
		if ( isset( $options['email'] ) && ! empty( $options['email'] ) ) {
			$email['to'] = $options['email'];
		}

		return $email;
	}

}