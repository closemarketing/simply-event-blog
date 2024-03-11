<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package    WordPress
 * @author     David Perez <david@close.technology>
 * @copyright  2024 Closemarketing
 * @version    1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simply_Event_Blog
 * @subpackage Simply_Event_Blog/public
 * @author     Closemarketing <info@closemarketing.es>
 */
class Simply_Event_Blog_Public {
	/**
	 * Array of days
	 *
	 * @var array
	 */
	private $days;

	/**
	 * Array of months
	 *
	 * @var array
	 */
	private $months;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->months = array(
			__( 'Jan', 'simply-event-blog' ),
			__( 'Feb', 'simply-event-blog' ),
			__( 'Mar', 'simply-event-blog' ),
			__( 'Apr', 'simply-event-blog' ),
			__( 'May', 'simply-event-blog' ),
			__( 'Jun', 'simply-event-blog' ),
			__( 'Jul', 'simply-event-blog' ),
			__( 'Aug', 'simply-event-blog' ),
			__( 'Sep', 'simply-event-blog' ),
			__( 'Nov', 'simply-event-blog' ),
			__( 'Dec', 'simply-event-blog' ),
		);
		$this->days   = array(
			__( 'Mon', 'simply-event-blog' ),
			__( 'Tue', 'simply-event-blog' ),
			__( 'Wed', 'simply-event-blog' ),
			__( 'Thu', 'simply-event-blog' ),
			__( 'Fri', 'simply-event-blog' ),
			__( 'Sat', 'simply-event-blog' ),
			__( 'Sun', 'simply-event-blog' ),
		);

		add_action( 'generate_before_content', array( $this, 'adds_html_date' ), 10 );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style(
			'simply-event-blog',
			SEB_PLUGIN_URL . 'css/simply-event-blog-public.css',
			array(),
			SEB_VERSION,
			'all'
		);
	}

	/**
	 * Adds html for date
	 *
	 * @return void
	 */
	public function adds_html_date() {
		$post_id        = get_the_ID();
		$seb_date_start = get_post_meta( $post_id, 'seb_date_start', true );
		$seb_date_fin   = get_post_meta( $post_id, 'seb_date_fin', true );
		$seb_time_fin   = get_post_meta( $post_id, 'seb_time_fin', true );

		if ( $seb_date_start ) {
			echo '<div class="simply-event-blog">';
			echo '<div class="day day-start">';
			echo '<p class="monthday">' . esc_html( ltrim( gmdate( 'd', strtotime( $seb_date_start ) ), '0' ) ) . '</p>';
			echo '<p class="month">' . esc_html( $this->months[ gmdate( 'n', strtotime( $seb_date_start ) ) - 1 ] ) . '</p>';
			echo '<p class="time">' . esc_html( gmdate( 'H:i', strtotime( $seb_time_fin ) ) ) . '</p>';
			echo '</div>';

			if ( $seb_date_fin ) {
				echo '<div class="separator">-</div>';
				echo '<div class="day day-fin">';
				echo '<p class="monthday">' . esc_html( ltrim( gmdate( 'd', strtotime( $seb_date_fin ) ), '0' ) ) . '</p>';
				echo '<p class="month">' . esc_html( $this->months[ gmdate( 'n', strtotime( $seb_date_fin ) ) - 1 ] ) . '</p>';
				echo '<p class="time">' . esc_html( gmdate( 'H:i', strtotime( $seb_time_fin ) ) ) . '</p>';
				echo '</div>';
			}
			echo '</div>';
		}
	}
}

new Simply_Event_Blog_Public();
