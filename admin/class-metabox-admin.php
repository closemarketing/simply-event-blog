<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.close.marketing
 * @since      1.0.0
 *
 * @package    Simply_Event_Blog
 * @subpackage Simply_Event_Blog/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simply_Event_Blog
 * @subpackage Simply_Event_Blog/admin
 * @author     Closemarketing <info@closemarketing.es>
 */
class Simply_Event_Blog_Admin {
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'metabox_date' ) );
		add_action( 'save_post', array( $this, 'metabox_date_save' ) );
	}

	/**
	 * Creates Metabox Container
	 *
	 * @return void
	 */
	public function metabox_date() {
		add_meta_box(
			'simply-event-blog',
			__( 'Event date', 'simply-event-blog' ),
			array( $this, 'metabox_date_content' ),
			'post',
			'side',
			'high'
		);
	}

	/**
	 * Creates Content for metabox
	 *
	 * @param object $post Post object.
	 * @return void
	 */
	public function metabox_date_content( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'seb_metabox_date' );
		$seb_date_start = get_post_meta( $post->ID, 'seb_date_start', true );
		$seb_time_start = get_post_meta( $post->ID, 'seb_time_start', true );
		$seb_date_fin   = get_post_meta( $post->ID, 'seb_date_fin', true );
		$seb_time_fin   = get_post_meta( $post->ID, 'seb_time_fin', true );
		$seb_address_1  = get_post_meta( $post->ID, 'seb_address_1', true );
		$seb_address_2  = get_post_meta( $post->ID, 'seb_address_2', true );
		$seb_zip        = get_post_meta( $post->ID, 'seb_zip', true );
		$seb_city       = get_post_meta( $post->ID, 'seb_city', true );
		$seb_state      = get_post_meta( $post->ID, 'seb_state', true );

		esc_html_e( 'Adds the information for the event in this post.', 'simply-event-blog' );
		?>
		<br/>
		<p>
			<label for="seb_date_start"><?php esc_html_e( 'Date start', 'simply-event-blog' ); ?></label>
			<br/>
			<input type="date" name="seb_date_start" id="seb_date_start" class="event-date" value="<?php echo esc_html( $seb_date_start ); ?>" />
		</p>
		<p>
			<label for="seb_time_start"><?php esc_html_e( 'Time start', 'simply-event-blog' ); ?></label>
			<br/>
			<input type="time" name="seb_time_start" id="seb_time_start" class="event-hour" value="<?php echo esc_html( $seb_time_start ); ?>" />
		</p>
		<p>
			<label for="seb_date_finish"><?php esc_html_e( 'Date finish', 'simply-event-blog' ); ?></label>
			<br/>
			<input type="date" name="seb_date_fin" id="seb_date_fin" class="event-date" value="<?php echo esc_html( $seb_date_fin ); ?>" />
		</p>
		<p>
			<label for="seb_time_fin"><?php esc_html_e( 'Time finish', 'simply-event-blog' ); ?></label>
			<br/>
			<input type="time" name="seb_time_fin" id="seb_time_fin" class="event-hour" value="<?php echo esc_html( $seb_time_fin ); ?>" />
		</p>
		<p>
			<label for="seb_address_1"><?php esc_html_e( 'Address 1', 'simply-event-blog' ); ?></label>
			<br/>
			<input type="text" name="seb_address_1" id="seb_address_1" class="event-address" value="<?php echo esc_html( $seb_address_1 ); ?>" />
		</p>
		<p>
			<label for="seb_address_2"><?php esc_html_e( 'Address 2', 'simply-event-blog' ); ?></label>
			<br/>
			<input type="text" name="seb_address_2" id="seb_address_2" class="event-address" value="<?php echo esc_html( $seb_address_2 ); ?>" />
		</p>
		<p>
			<label for="seb_zip"><?php esc_html_e( 'ZIP', 'simply-event-blog' ); ?></label>
			<br/>
			<input type="text" name="seb_zip" id="seb_zip" class="event-address" value="<?php echo esc_html( $seb_zip ); ?>" />
		</p>
		<p>
			<label for="seb_city"><?php esc_html_e( 'City', 'simply-event-blog' ); ?></label>
			<br/>
			<input type="text" name="seb_city" id="seb_city" class="event-address" value="<?php echo esc_html( $seb_city ); ?>" />
		</p>
		<p>
			<label for="seb_state"><?php esc_html_e( 'State', 'simply-event-blog' ); ?></label>
			<br/>
			<input type="text" name="seb_state" id="seb_state" class="event-address" value="<?php echo esc_html( $seb_state ); ?>" />
		</p>
		<?php
	}

	/**
	 * Validate the date
	 *
	 * @param straing $date Date to validate.
	 * @param string  $format Format of date.
	 * @return boolean
	 */
	private function validate_date( $date, $format = 'Y-m-d' ) {
		$date_to_validate = DateTime::createFromFormat( $format, $date );
		return $date_to_validate && $date_to_validate->format( $format ) == $date;
	}

	/**
	 * Metabox save
	 *
	 * @param string $post_id Post ID of save.
	 * @return $post_id
	 */
	public function metabox_date_save( $post_id ) {

		if ( ! isset( $_POST['seb_metabox_date'] ) || ! wp_verify_nonce( $_POST['seb_metabox_date'], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		// Si el usuario actual no puede editar entradas no debería estar aquí.
		if ( ! current_user_can( 'edit_post' ) ) {
			return;
		}
		$allowed = array();
		if ( isset( $_POST['seb_date_start'] ) && $this->validate_date( $_POST['seb_date_start'] ) ) {
			update_post_meta( $post_id, 'seb_date_start', sanitize_text_field( wp_unslash( $_POST['seb_date_start'] ) ) );
		}
		if ( isset( $_POST['seb_time_start'] ) ) {
			update_post_meta( $post_id, 'seb_time_start', sanitize_text_field( wp_unslash( $_POST['seb_time_start'] ) ) );
		}
		if ( isset( $_POST['seb_date_fin'] ) ) {
			update_post_meta( $post_id, 'seb_date_fin', sanitize_text_field( wp_unslash( $_POST['seb_date_fin'] ) ) );
		}
		if ( isset( $_POST['seb_time_fin'] ) ) {
			update_post_meta( $post_id, 'seb_time_fin', sanitize_text_field( wp_unslash( $_POST['seb_time_fin'] ) ) );
		}
		if ( isset( $_POST['seb_address_1'] ) ) {
			update_post_meta( $post_id, 'seb_address_1', sanitize_text_field( wp_unslash( $_POST['seb_address_1'] ) ) );
		}
		if ( isset( $_POST['seb_address_2'] ) ) {
			update_post_meta( $post_id, 'seb_address_2', sanitize_text_field( wp_unslash( $_POST['seb_address_2'] ) ) );
		}
		if ( isset( $_POST['seb_zip'] ) ) {
			update_post_meta( $post_id, 'seb_zip', sanitize_text_field( wp_unslash( $_POST['seb_zip'] ) ) );
		}
		if ( isset( $_POST['seb_city'] ) ) {
			update_post_meta( $post_id, 'seb_city', sanitize_text_field( wp_unslash( $_POST['seb_city'] ) ) );
		}
		if ( isset( $_POST['seb_state'] ) ) {
			update_post_meta( $post_id, 'seb_state', sanitize_text_field( wp_unslash( $_POST['seb_state'] ) ) );
		}
	}
}

new Simply_Event_Blog_Admin();
