<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package Background_Update_Notification_Email_Address
 * @author Phil Wylie <phil@iweb.co.uk>
 * @license GPL-2.0+
 * @link https://github.com/iwebsolutions/background-update-notification-email-address
 * @copyright 2014 Interactive Web Solutions Ltd
 */
?>

<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<form method="POST" action="options.php">
		<?php
			settings_fields( 'update_notification_email_address_option_group' );
			do_settings_sections( $this->plugin_slug );
			submit_button( __( 'Save Changes', $this->plugin_slug ), 'primary', 'update_notification_email_address_options[submit]' );
		?>
	</form>

</div>