<?php
/**
 * widget-contact-footer.php
 * 
 * Plugin Name: Eventify_Widget_Contact_Footer
 * Plugin URI: http://www.oracular.com
 * Description: A widget that displays Contact Us information.
 * Version: 1.0
 * Author: Oracular
 * Author URI: http://www.oracular.com
*/

class Eventify_Widget_Contact_Footer extends WP_Widget {

	/**
	 * Specifies the widget name, description, class name and instatiates it
	 */
	public function __construct() {
		parent::__construct( 
			'widget-contact-footer',
			__( 'Eventify: Contact Info', 'eventify' ),
			array(
				'classname'   => 'widget-contact-footer',
				'description' => __( 'A custom widget that displays contact us info.', 'eventify' )
			) 
		);
	}


	/**
	 * Generates the back-end layout for the widget
	 */
	public function form( $instance ) {
		// Default widget settings
		$defaults = array(
			'eventify_info'       => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
			'eventify_address'    => '120 Jackson Street, Oshkosh, WI',
			'eventify_email' 	  => 'info@eventify.com',
			'eventify_phone' 	  => '+1-234-567-890'
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		// The widget content ?>
		<!-- Information -->
		<p>
			<label for="<?php echo $this->get_field_id( 'eventify_info' ); ?>"><?php _e( 'Information:', 'eventify' ); ?></label>
			<textarea rows="4" class="widefat" id="<?php echo $this->get_field_id( 'eventify_info' ); ?>" name="<?php echo $this->get_field_name( 'eventify_info' ); ?>"><?php echo esc_attr( $instance['eventify_info'] ); ?></textarea>
		</p>

		<!-- Address -->
		<p>
			<label for="<?php echo $this->get_field_id( 'eventify_address' ); ?>"><?php _e( 'Address:', 'eventify' ); ?></label>
			<textarea rows="3" class="widefat" id="<?php echo $this->get_field_id( 'eventify_address' ); ?>" name="<?php echo $this->get_field_name( 'eventify_address' ); ?>"><?php echo esc_attr( $instance['eventify_address'] ); ?></textarea>
		</p> 

		<!-- Email -->
		<p>
			<label for="<?php echo $this->get_field_id( 'eventify_email' ); ?>"><?php _e( 'Email:', 'eventify' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'eventify_email' ); ?>" name="<?php echo $this->get_field_name( 'eventify_email' ); ?>" value="<?php echo esc_attr( $instance['eventify_email'] ); ?>">
		</p>

		<!-- Phone -->
		<p>
			<label for="<?php echo $this->get_field_id( 'eventify_phone' ); ?>"><?php _e( 'Phone:', 'eventify' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'eventify_phone' ); ?>" name="<?php echo $this->get_field_name( 'eventify_phone' ); ?>" value="<?php echo esc_attr( $instance['eventify_phone'] ); ?>">
		</p> <?php
	}


	/**
	 * Processes the widget's values
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Update values
		$instance['eventify_info']     = strip_tags( stripslashes( $new_instance['eventify_info'] ) );
		$instance['eventify_address']  = $new_instance['eventify_address'];
		$instance['eventify_phone']    = strip_tags( stripslashes( $new_instance['eventify_phone'] ) );
		$instance['eventify_email']    = strip_tags( stripslashes( $new_instance['eventify_email'] ) );

		return $instance;
	}


	/**
	 * Output the contents of the widget
	 */
	public function widget( $args, $instance ) {
		// Extract the arguments
		extract( $args );

		$eventify_info      = apply_filters( 'widget_desc', $instance['eventify_info'] );
		$eventify_address   = $instance['eventify_address'];
		$eventify_phone     = $instance['eventify_phone'];
		$eventify_email     = $instance['eventify_email'];

		// Display the markup before the widget (as defined in functions.php)
		echo $before_widget;

		if ( $eventify_info ) { ?>
			<div class="desc">
				<?php echo $eventify_info; ?>
			</div>
		<?php }

		echo '<table><tbody class="tbl-info">';

		if ( $eventify_address ) : ?>
			<tr>
				<td>
					<i class="fa fa-map-marker"></i>
				</td>
				<td>
					<span><?php _e( '', 'eventify' ); ?></span>
					<?php echo $eventify_address; ?>
				</td>
			</tr>
		<?php endif;

		if ( $eventify_email ) : ?>
			<tr>
				<td>
					<i class="fa fa-envelope"></i>
				</td>
				<td>
					<span><?php _e( '', 'eventify' ); ?></span>
					<?php echo '<a href="mailto:'.$eventify_email.'">'.$eventify_email.'</a>'; ?>
				</td>
			</tr>
		<?php endif;

		if ( $eventify_phone ) : ?>
			<tr>
				<td>
					<i class="fa fa-phone"></i>
				</td>
				<td>
					<span><?php _e( '', 'eventify' ); ?></span>
					<?php echo $eventify_phone; ?>
				</td>
			</tr>
		<?php endif;

		echo '</tbody></table>';

		// Display the markup after the widget (as defined in functions.php)
		echo $after_widget;
	}
}

// Register the widget using an annonymous function
add_action( 'widgets_init', create_function( '', 'register_widget( "Eventify_Widget_Contact_Footer" );' ) );
?>