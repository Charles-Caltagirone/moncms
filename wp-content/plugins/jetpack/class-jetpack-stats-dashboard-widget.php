<?php
/**
 * Adds the Jetpack stats widget to the WordPress admin dashboard.
 *
 * @package jetpack
 */

use Automattic\Jetpack\Assets;
use Automattic\Jetpack\Assets\Logo as Jetpack_Logo;
use Automattic\Jetpack\Redirect;
use Automattic\Jetpack\Status;

/**
 * Class that adds the Jetpack stats widget to the WordPress admin dashboard.
 */
class Jetpack_Stats_Dashboard_Widget {

	/**
	 * Indicates whether the class initialized or not.
	 *
	 * @var bool
	 */
	private static $initialized = false;

	/**
	 * Initialize the class by calling the setup static function.
	 *
	 * @return void
	 */
	public static function init() {
		if ( ! self::$initialized ) {
			self::$initialized = true;
			self::wp_dashboard_setup();
		}
	}

	/**
	 * Sets up the Jetpack Stats widget in the WordPress admin dashboard.
	 */
	public static function wp_dashboard_setup() {

		/**
		 * Filter whether the Jetpack Stats dashboard widget should be shown to the current user.
		 * By default, the dashboard widget is shown to users who can view_stats.
		 *
		 * @module stats
		 * @since 11.9
		 *
		 * @param bool Whether to show the widget to the current user.
		 */
		if ( ! apply_filters( 'jetpack_stats_dashboard_widget_show_to_user', current_user_can( 'view_stats' ) ) ) {
			return;
		}

		if ( Jetpack::is_connection_ready() ) {
			add_action( 'jetpack_dashboard_widget', array( __CLASS__, 'dashboard_widget_footer' ), 999 );
		}

		if ( has_action( 'jetpack_dashboard_widget' ) ) {
			$widget_title = sprintf(
				__( 'Jetpack Stats', 'jetpack' )
			);

			wp_add_dashboard_widget(
				'jetpack_summary_widget',
				$widget_title,
				array( __CLASS__, 'dashboard_widget' )
			);
			wp_enqueue_style(
				'jetpack-dashboard-widget',
				Assets::get_file_url_for_environment(
					'css/dashboard-widget.min.css',
					'css/dashboard-widget.css'
				),
				array(),
				JETPACK__VERSION
			);
			wp_style_add_data( 'jetpack-dashboard-widget', 'rtl', 'replace' );
		}
	}

	/**
	 * Fires dashboard widget action.
	 * Both the footer from this file and the stats graph from modules/stats.php hook into this action.
	 */
	public static function dashboard_widget() {
		/**
		 * Fires when the dashboard is loaded.
		 *
		 * @since 3.4.0
		 */
		do_action( 'jetpack_dashboard_widget' );
	}

	/**
	 * Load the widget footer showing Akismet stats.
	 */
	public static function dashboard_widget_footer() {
		?>
		<footer>
		<div class="blocked-container">
			<div class="protect">
				<h3><?php esc_html_e( 'Brute force attack protection', 'jetpack' ); ?></h3>
				<?php if ( Jetpack::is_module_active( 'protect' ) ) : ?>
					<p class="blocked-count">
						<?php echo esc_html( number_format_i18n( get_site_option( 'jetpack_protect_blocked_attempts', 0 ) ) ); ?>
					</p>
					<p><?php echo esc_html_x( 'Blocked malicious login attempts', '{#} Blocked malicious login attempts -- number is on a prior line, text is a caption.', 'jetpack' ); ?></p>
				<?php elseif ( current_user_can( 'jetpack_activate_modules' ) && ! ( new Status() )->is_offline_mode() ) : ?>
					<a href="
					<?php
					echo esc_url(
						wp_nonce_url(
							Jetpack::admin_url(
								array(
									'action' => 'activate',
									'module' => 'protect',
								)
							),
							'jetpack_activate-protect'
						)
					);
					?>
								" class="button button-jetpack" title="<?php esc_attr_e( 'Protect helps to keep you secure from brute-force login attacks.', 'jetpack' ); ?>">
						<?php esc_html_e( 'Activate brute force attack protection', 'jetpack' ); ?>
					</a>
				<?php else : ?>
					<?php esc_html_e( 'Brute force attack protection is inactive.', 'jetpack' ); ?>
				<?php endif; ?>
			</div>

			<div class="akismet">
				<h3><?php esc_html_e( 'Akismet Anti-spam', 'jetpack' ); ?></h3>
				<?php if ( is_plugin_active( 'akismet/akismet.php' ) ) : ?>
					<p class="blocked-count">
						<?php echo esc_html( number_format_i18n( get_option( 'akismet_spam_count', 0 ) ) ); ?>
					</p>
					<p><?php echo esc_html_x( 'Blocked spam comments.', '{#} Spam comments blocked by Akismet -- number is on a prior line, text is a caption.', 'jetpack' ); ?></p>
				<?php elseif ( current_user_can( 'activate_plugins' ) && ! is_wp_error( validate_plugin( 'akismet/akismet.php' ) ) ) : ?>
					<a href="
					<?php
					echo esc_url(
						wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'activate',
									'plugin' => 'akismet/akismet.php',
								),
								admin_url( 'plugins.php' )
							),
							'activate-plugin_akismet/akismet.php'
						)
					);
					?>
								" class="button button-jetpack">
						<?php esc_html_e( 'Activate Anti-spam', 'jetpack' ); ?>
					</a>
				<?php else : ?>
					<p><a href="<?php echo esc_url( 'https://akismet.com/?utm_source=jetpack&utm_medium=link&utm_campaign=Jetpack%20Dashboard%20Widget%20Footer%20Link' ); ?>"><?php esc_html_e( 'Anti-spam can help to keep your blog safe from spam!', 'jetpack' ); ?></a></p>
				<?php endif; ?>
			</div>
		</div>
		<div class="footer-links">
			<?php
				$jetpack_logo = new Jetpack_Logo();
				echo $jetpack_logo->get_jp_emblem( true );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			if ( Jetpack::is_module_active( 'stats' ) ) :
				?>
				<span>
					<?php
					if ( current_user_can( 'jetpack_manage_modules' ) ) :
						$i18n_headers = jetpack_get_module_i18n( 'stats' );
						?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=jetpack#/settings?term=' . rawurlencode( $i18n_headers['name'] ) ) ); ?>"
					>
						<?php
						esc_html_e( 'Configure Jetpack Stats', 'jetpack' );
						?>
				</a>
				|
						<?php
						endif;
					?>
				<a href="<?php echo esc_url( Redirect::get_url( 'jetpack-support-wordpress-com-stats' ) ); ?>" target="_blank"><?php esc_html_e( 'Learn more', 'jetpack' ); ?></a>
				</span>
				<?php
			endif;
			?>

		</div>
		</footer>

		<?php
	}
}
