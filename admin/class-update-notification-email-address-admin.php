<?php
/**
 * Background_Update_Notification_Email_Address
 *
 * @package Background_Update_Notification_Email_Address_Admin
 * @author Phil Wylie <phil@iweb.co.uk>
 * @license GPL-2.0+
 * @link http://wordpress.org/plugins/background-update-notification-email-address/
 * @copyright 2014 Interactive Web Solutions Ltd
 */

/**
 * Background_Update_Notification_Email_Address_Admin class. This class handles
 * the admin side of the plugin, creating an options page and saving settings.
 *
 * @package Background_Update_Notification_Email_Address_Admin
 * @author Phil Wylie <phil@iweb.co.uk>
 */
class Background_Update_Notification_Email_Address_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by adding a settings page and menu.
	 *
	 * @since 1.0.0
	 *
	 * @global string $pagenow
	 */
	private function __construct() {
		global $pagenow;

		// Call $plugin_slug from public plugin class.
		$plugin = Background_Update_Notification_Email_Address::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		// Register our settings. Add the settings section and settings fields.
		if ( ! empty ( $pagenow ) && ( 'options-general.php' === $pagenow || 'options.php' === $pagenow ) ) {
			add_action( 'admin_init', array( $this, 'register_settings' ) );
		}

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
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since 1.0.0
	 */
	public function add_plugin_admin_menu() {

		// Add a settings page for this plugin to the Settings menu.
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Background Update Notification Email Address', $this->plugin_slug ),
			__( 'Update Notifications', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since 1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Register our settings. Add the settings section and settings fields.
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {
		$option_name = 'update_notification_email_address_options';

		// Get existing options.
		$option_values = get_option( $option_name );

		// Set default values.
		$default_values = array(
			'email' => get_bloginfo( 'admin_email' ),
		);

		// Parse option values and discard the rest.
		$data = shortcode_atts( $default_values, $option_values );

		register_setting(
			'update_notification_email_address_option_group',
			$option_name,
			array( $this, 'update_notification_email_address_options_validate' )
		);

		add_settings_section(
			'email_settings',
			__( 'Email Settings', $this->plugin_slug ),
			'__return_false',
			$this->plugin_slug
		);

		add_settings_field(
			'email',
			__( 'Email Address', $this->plugin_slug ),
			array( $this, 'render_email_field' ),
			$this->plugin_slug,
			'email_settings',
			array(
				'label_for' => 'email',
				'name' => 'email',
				'value' => esc_attr( $data['email'] ),
				'option_name' => $option_name,
				'type' => 'email'
			)
		);

	}

	/**
	 * Render the email field.
	 *
	 * @since 1.0.0
	 */
	function render_email_field( $args ) {
		printf(
			'<input name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text" type="%5$s">',
			$args['option_name'],
			$args['name'],
			$args['label_for'],
			$args['value'],
			$args['type']
		);

	}

	/**
	 * Validation callback
	 *
	 * @since 1.0.0
	 */
	public function update_notification_email_address_options_validate( $input ) {
		$options = get_option( 'update_notification_email_address_options' );

		if ( ! is_array( $input ) ) {
			return $options;
		}

		if ( isset( $input['submit'] ) ) {

			// Get fields.
			$email = isset( $input['email'] ) ? $input['email'] : '';

			// Validate fields.
			if ( empty( $email ) ) {
				add_settings_error( 'email', 'email_error', __( 'An email address is required', $this->plugin_slug ), 'error' );
			} else {
				if ( ! is_email( $email ) ) {
					add_settings_error( 'email', 'email_error', __( 'A valid email address is required', $this->plugin_slug ), 'error' );
				} else {
					$options['email'] = sanitize_email( $email );
				}
			}

		}

		return $options;
	}

}