<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ivole_Admin_Diag' ) ) :

	require_once('class-ivole-admin.php');

	class  Ivole_Admin_Diag extends Ivole_Admin  {

		 // constructor
		 public function __construct() {
			$this->id    = 'ivole';
			add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
			add_action( 'woocommerce_admin_field_ivolediag', array( $this, 'show_report' ) );
		 }

		 /**
			* Output the settings.
			*/
		 public function output() {
			 global $current_section;
			 if( $current_section === 'ivole_diagnostics' ) {
				 	$GLOBALS['hide_save_button'] = true;
					$settings = $this->get_settings( $current_section );
					WC_Admin_Settings::output_fields( $settings);
			 }
		 }

		// getting
		public function get_settings( $current_section = '' ) {
				$settings = array(
					array(
		        		'title' => __( 'Diagnostics Information', IVOLE_TEXT_DOMAIN ),
		        		'type' => 'title',
		        		'desc' => __( 'Diagnostic report about parameters of your website configuration that are important for Customer Reviews plugin. If there are any errors or warnings below, the plugin might not work properly.', IVOLE_TEXT_DOMAIN ),
		        		'id' => 'ivole_diagnostics_title'
		      		),
        	array(
              'name' => __( 'Diagnostics Information', IVOLE_TEXT_DOMAIN ),
              'type' => 'ivolediag',
              'desc' => '',
              'id'   => 'ivole_diagnostics_info'
          )
        );
			 return $settings;
		}

		public function show_report( $value ) {
			$curl_version =  curl_version();
			$curl_version =   $curl_version["version"];
			$test_secret_key = bin2hex(openssl_random_pseudo_bytes(16));
			update_option( 'ivole_test_secret_key', $test_secret_key );
			$test_data = array(
				'test' => $test_secret_key
			);
			$body_data = json_encode( $test_data );
			$post_response = wp_safe_remote_post( get_rest_url( null, '/ivole/v1/review' ), array(
            'timeout'     => 10,
            'user-agent'  => 'CRivole',
            'httpversion' => '1.1',
            'body'        => $body_data
      ) );
			//error_log( print_r( $post_response, true ) );
			$rest_API = false;
			if ( ! is_wp_error( $post_response ) && $post_response['response']['code'] === 200 ) {
				$rest_API = true;
      }
			?>
			<table class="wc_status_table widefat" cellspacing="0" id="status">
				<tbody>
					<tr>
						<td data-export-label="Home URL"><?php echo __( 'WP Version:', IVOLE_TEXT_DOMAIN ); ?></td>
						<td class="help"><?php echo Ivole_Admin::ivole_wc_help_tip( __( 'The version of WordPress installed on your site.', IVOLE_TEXT_DOMAIN ) ); ?></td>
						<td><?php echo get_bloginfo( 'version' ); ?></td>
					</tr>
					<tr>
						<td data-export-label="WC Version"><?php echo __( 'WC Version:', IVOLE_TEXT_DOMAIN ); ?></td>
						<td class="help"><?php echo Ivole_Admin::ivole_wc_help_tip( __( 'The version of WooCommerce installed on your site.', IVOLE_TEXT_DOMAIN ) ); ?></td>
						<td><?php echo $this->get_woo_version_number(); ?></td>
					</tr>
					<tr>
						<td data-export-label="cURL Version"><?php echo __( 'cURL Version:', IVOLE_TEXT_DOMAIN ); ?></td>
						<td class="help"><?php echo Ivole_Admin::ivole_wc_help_tip( __( 'The version of cURL library installed on your site.', IVOLE_TEXT_DOMAIN ) ); ?></td>
						<td><?php echo $curl_version; ?></td>
					</tr>
					<tr>
						<td data-export-label="WP Cron"><?php echo __( 'WP Cron:', IVOLE_TEXT_DOMAIN ); ?></td>
						<td class="help"><?php echo Ivole_Admin::ivole_wc_help_tip( __( 'Displays whether or not WP Cron Jobs are enabled.', IVOLE_TEXT_DOMAIN ) ); ?></td>
						<td><?php if ( ! defined( 'DISABLE_WP_CRON' ) ) : ?>
							<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
						<?php else : ?>
							<mark class="no">&ndash;</mark>
						<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td data-export-label="WP REST API"><?php echo __( 'WP REST API:', IVOLE_TEXT_DOMAIN ); ?></td>
						<td class="help"><?php echo Ivole_Admin::ivole_wc_help_tip( __( 'Displays whether or not WP REST API is enabled.', IVOLE_TEXT_DOMAIN ) ); ?></td>
						<td><?php if ( $rest_API ) : ?>
							<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
						<?php else :
							echo '<mark class="error"><span class="dashicons dashicons-warning"></span>' . __( 'The plugin will not be able to receive reviews because REST API is disabled.', IVOLE_TEXT_DOMAIN ) . '</mark>';
						endif; ?>
					</tr>
					<tr>
						<td data-export-label="WC Slider"><?php echo __( 'WC Slider:', IVOLE_TEXT_DOMAIN ); ?></td>
						<td class="help"><?php echo Ivole_Admin::ivole_wc_help_tip( __( 'Displays whether or not WooCommerce Slider library is enabled.', IVOLE_TEXT_DOMAIN ) ); ?></td>
						<td><?php if ( current_theme_supports( 'wc-product-gallery-slider' ) ) : ?>
							<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
						<?php else :
							echo '<mark class="error"><span class="dashicons dashicons-warning"></span>' . '</mark>';
						endif; ?>
					</tr>
					<tr>
						<td data-export-label="WC Zoom"><?php echo __( 'WC Zoom:', IVOLE_TEXT_DOMAIN ); ?></td>
						<td class="help"><?php echo Ivole_Admin::ivole_wc_help_tip( __( 'Displays whether or not WooCommerce Zoom library is enabled.', IVOLE_TEXT_DOMAIN ) ); ?></td>
						<td><?php if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) : ?>
							<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
						<?php else :
							echo '<mark class="error"><span class="dashicons dashicons-warning"></span>' . '</mark>';
						endif; ?>
					</tr>
					<tr>
						<td data-export-label="WC Lightbox"><?php echo __( 'WC Lightbox:', IVOLE_TEXT_DOMAIN ); ?></td>
						<td class="help"><?php echo Ivole_Admin::ivole_wc_help_tip( __( 'Displays whether or not WooCommerce Lightbox library is enabled.', IVOLE_TEXT_DOMAIN ) ); ?></td>
						<td><?php if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) : ?>
							<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
						<?php else :
							echo '<mark class="error"><span class="dashicons dashicons-warning"></span>' . '</mark>';
						endif; ?>
					</tr>
				</tbody>
			</table>
			<?php
		}

		private function get_woo_version_number() {
			// If get_plugins() isn't available, require it
			if ( ! function_exists( 'get_plugins' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			// Create the plugins folder and file variables
			$plugin_folder = get_plugins( '/' . 'woocommerce' );
			$plugin_file = 'woocommerce.php';

			// If the plugin version number is set, return it
			if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
				return $plugin_folder[$plugin_file]['Version'];

			} else {
			// Otherwise return null
				return NULL;
			}
		}
}

endif;



?>
