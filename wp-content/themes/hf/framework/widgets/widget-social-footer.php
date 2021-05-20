<?php
/**
 * widget-social-footer.php
 * 
 * Plugin Name: Eventify_Widget_Social_Footer
 * Plugin URI: http://www.oracular.com
 * Description: A widget that displays Contact Us information.
 * Version: 1.0
 * Author: Oracular
 * Author URI: http://www.oracular.com
*/

class Eventify_Widget_Social_Footer extends WP_Widget {

	/**
	 * Specifies the widget name, description, class name and instatiates it
	 */
	public function __construct() {
		parent::__construct( 
			'widget-social-footer',
			__( 'Eventify: Social Icons', 'eventify' ),
			array(
				'classname'   => 'widget-social-footer',
				'description' => __( 'A custom widget that displays social icons.', 'eventify' )
			) 
		);
	}


	/**
	 * Generates the back-end layout for the widget
	 */
	public function form( $instance ) {
		// Default widget settings
		$defaults = array(
			'eventify_facebook'   => '#',
			'facebook_check'      => 'on',
			'eventify_twitter'    => '#',
			'twitter_check'       => 'on',
			'eventify_google' 	  => '#',
			'google_check'        => 'on',
			'eventify_insta' 	  => '#',
			'insta_check'         => 'on',
			'eventify_mail' 	  => '#',
			'mail_check'          => 'on'
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		// The widget content ?>
		<!-- Facebook checkbox -->
	    <p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance[ 'facebook_check' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'facebook_check' ); ?>" name="<?php echo $this->get_field_name( 'facebook_check' ); ?>" /> 
	        <label for="<?php echo $this->get_field_id( 'facebook_check' ); ?>">Facebook</label>
	    </p>
		<!-- Facebook -->
		<p>
			<label for="<?php echo $this->get_field_id( 'eventify_facebook' ); ?>"><?php _e( 'Facebook URL:', 'eventify' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'eventify_facebook' ); ?>" name="<?php echo $this->get_field_name( 'eventify_facebook' ); ?>" value="<?php echo esc_attr( $instance['eventify_facebook'] ); ?>">
		</p>

		<!-- Twitter checkbox -->
	    <p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance[ 'twitter_check' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'twitter_check' ); ?>" name="<?php echo $this->get_field_name( 'twitter_check' ); ?>" /> 
	        <label for="<?php echo $this->get_field_id( 'twitter_check' ); ?>">Twitter</label>
	    </p>
		<!-- Twitter -->
		<p>
			<label for="<?php echo $this->get_field_id( 'eventify_twitter' ); ?>"><?php _e( 'Twitter URL:', 'eventify' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'eventify_twitter' ); ?>" name="<?php echo $this->get_field_name( 'eventify_twitter' ); ?>" value="<?php echo esc_attr( $instance['eventify_twitter'] ); ?>">
		</p>

		<!-- Google checkbox -->
	    <p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance[ 'google_check' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'google_check' ); ?>" name="<?php echo $this->get_field_name( 'google_check' ); ?>" /> 
	        <label for="<?php echo $this->get_field_id( 'google_check' ); ?>">Google Plus</label>
	    </p>
		<!-- Google -->
		<p>
			<label for="<?php echo $this->get_field_id( 'eventify_google' ); ?>"><?php _e( 'Google Plus URL:', 'eventify' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'eventify_google' ); ?>" name="<?php echo $this->get_field_name( 'eventify_google' ); ?>" value="<?php echo esc_attr( $instance['eventify_google'] ); ?>">
		</p>

		<!-- Instagram checkbox -->
	    <p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance[ 'insta_check' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'insta_check' ); ?>" name="<?php echo $this->get_field_name( 'insta_check' ); ?>" /> 
	        <label for="<?php echo $this->get_field_id( 'insta_check' ); ?>">Instagram</label>
	    </p>
		<!-- Instagram -->
		<p>
			<label for="<?php echo $this->get_field_id( 'eventify_insta' ); ?>"><?php _e( 'Instagram URL:', 'eventify' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'eventify_insta' ); ?>" name="<?php echo $this->get_field_name( 'eventify_insta' ); ?>" value="<?php echo esc_attr( $instance['eventify_insta'] ); ?>">
		</p>

		<!-- Mail checkbox -->
	    <p>
	        <input class="checkbox" type="checkbox" <?php checked( $instance[ 'mail_check' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'mail_check' ); ?>" name="<?php echo $this->get_field_name( 'mail_check' ); ?>" /> 
	        <label for="<?php echo $this->get_field_id( 'mail_check' ); ?>">Mail</label>
	    </p>
		<!-- Mail -->
		<p>
			<label for="<?php echo $this->get_field_id( 'eventify_mail' ); ?>"><?php _e( 'Mail URL:', 'eventify' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'eventify_mail' ); ?>" name="<?php echo $this->get_field_name( 'eventify_mail' ); ?>" value="<?php echo esc_attr( $instance['eventify_mail'] ); ?>">
		</p>


		<?php
	}


	/**
	 * Processes the widget's values
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Update values
		$instance['eventify_facebook'] = strip_tags( stripslashes( $new_instance['eventify_facebook'] ) );
		$instance['eventify_twitter']  = strip_tags( stripslashes( $new_instance['eventify_twitter'] ) );
		$instance['eventify_google']   = strip_tags( stripslashes( $new_instance['eventify_google'] ) );
		$instance['eventify_insta']    = strip_tags( stripslashes( $new_instance['eventify_insta'] ) );
		$instance['eventify_mail']     = strip_tags( stripslashes( $new_instance['eventify_mail'] ) );
		$instance['facebook_check'] = $new_instance['facebook_check'];
		$instance['twitter_check']  = $new_instance['twitter_check'];
		$instance['google_check']   = $new_instance['google_check'];
		$instance['insta_check']    = $new_instance['insta_check'];
		$instance['mail_check']     = $new_instance['mail_check'];

		return $instance;
	}


	/**
	 * Output the contents of the widget
	 */
	public function widget( $args, $instance ) {
		// Extract the arguments
		extract( $args );

		$eventify_facebook = $instance['eventify_facebook'];
		$eventify_twitter  = $instance['eventify_twitter'];
		$eventify_google   = $instance['eventify_google'];
		$eventify_insta    = $instance['eventify_insta'];
		$eventify_mail     = $instance['eventify_mail'];
		$facebook_check    = $instance['facebook_check'];
		$twitter_check     = $instance['twitter_check'];
		$google_check      = $instance['google_check'];
		$insta_check       = $instance['insta_check'];
		$mail_check        = $instance['mail_check'];


		// Display the markup before the widget (as defined in functions.php)
		echo $before_widget;

		echo '<ul class="list-unstyled social-list">';

		if ( $facebook_check == 'on' ) : ?>
			<li>
				<a href="<?php echo $eventify_facebook; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
			</li>
		<?php endif;

		if ( $twitter_check == 'on' ) : ?>
			<li>
				<a href="<?php echo $eventify_twitter; ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			</li>
		<?php endif;

		if ( $google_check == 'on' ) : ?>
			<li>
				<a href="<?php echo $eventify_google; ?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
			</li>
		<?php endif;

		if ( $insta_check == 'on' ) : ?>
			<li>
				<a href="<?php echo $eventify_insta; ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
			</li>
		<?php endif;

		if ( $mail_check == 'on' ) : ?>
			<li>
				<a href="<?php echo $eventify_mail; ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a>
			</li>
		<?php endif;

		echo '</ul>';

		// Display the markup after the widget (as defined in functions.php)
		echo $after_widget;
	}
}

// Register the widget using an annonymous function
add_action( 'widgets_init', create_function( '', 'register_widget( "Eventify_Widget_Social_Footer" );' ) );
?>