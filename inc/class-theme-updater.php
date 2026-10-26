<?php
/**
 * LinkInBio — self-hosted theme updater
 *
 * Hooks into WordPress's update_themes transient and reads version
 * information from a JSON file on 369theme.com, so the theme can be
 * updated from the admin screen like a theme.org theme.
 *
 * Usage:
 *   new LinkInBio_Theme_Updater(
 *       array(
 *           'slug'       => 'linkinbio',
 *           'remote_url' => 'https://369theme.com/releases/linkinbio-info.json',
 *       )
 *   );
 *
 * Expected server-side JSON:
 *   {
 *       "version":      "1.2",
 *       "download_url": "https://369theme.com/releases/linkinbio-1.2.zip",
 *       "requires":     "6.7",
 *       "requires_php": "7.4",
 *       "tested":       "7.1"
 *   }
 *
 * @package linkinbio
 * @since   1.1.0
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'LinkInBio_Theme_Updater' ) ) {
	return;
}

/**
 * Reads release metadata from a self-hosted JSON endpoint and feeds it
 * into the core theme update flow.
 */
class LinkInBio_Theme_Updater {

	/**
	 * Theme slug (the theme's directory name).
	 *
	 * @var string
	 */
	private string $slug;

	/**
	 * URL of the remote JSON file.
	 *
	 * @var string
	 */
	private string $remote_url;

	/**
	 * Optional callback name returning a licence key.
	 *
	 * @var string|null
	 */
	private ?string $license_callback;

	/**
	 * Remote payload for this request. Array on success, false on
	 * failure, null while it has not been fetched yet.
	 *
	 * @var array|false|null
	 */
	private $remote_data = null;

	/**
	 * Cache lifetime for a successful lookup, in seconds.
	 *
	 * After this the server is asked again. Site owners never have to
	 * wait it out: the "Check for updates now" button clears it.
	 */
	const CACHE_TTL = HOUR_IN_SECONDS;

	/**
	 * Cache lifetime after a failed lookup, in seconds.
	 *
	 * A server error or a dropped connection is retried after five
	 * minutes rather than blocking updates for a full hour.
	 */
	const CACHE_TTL_FAILURE = 5 * MINUTE_IN_SECONDS;

	/**
	 * Sentinel value stored in the cache to mark a failed lookup.
	 *
	 * A failed lookup can't be told apart from "nothing stored" by
	 * get_transient(), so it is recorded with this string in the same
	 * transient instead of a second one.
	 */
	const CACHE_FAILURE_SENTINEL = '__linkinbio_updater_failed__';

	/**
	 * Constructor.
	 *
	 * @param array $args {
	 *     Updater configuration.
	 *
	 *     @type string      $slug             Theme directory name.
	 *     @type string      $remote_url       URL of the release JSON.
	 *     @type string|null $license_callback Optional callback returning a licence key.
	 * }
	 */
	public function __construct( array $args ) {
		$this->slug             = $args['slug'];
		$this->remote_url       = $args['remote_url'];
		$this->license_callback = isset( $args['license_callback'] ) ? $args['license_callback'] : null;

		add_filter( 'site_transient_update_themes', array( $this, 'check_update' ) );
		add_filter( 'themes_api', array( $this, 'theme_info' ), 20, 3 );

		// Admin only: the "check now" button and its result notice.
		if ( is_admin() ) {
			add_action( 'admin_init', array( $this, 'handle_force_check' ) );
			add_action( 'admin_notices', array( $this, 'show_force_check_notice' ) );
		}
	}

	// -------------------------------------------------------------------------
	// update_themes transient
	// -------------------------------------------------------------------------

	/**
	 * Inject the remote version into the update_themes transient.
	 *
	 * @param mixed $transient Transient value passed by WordPress.
	 * @return mixed
	 */
	public function check_update( $transient ) {
		if ( ! is_object( $transient ) ) {
			return $transient;
		}

		$remote = $this->get_remote_data();

		if ( false === $remote ) {
			return $transient;
		}

		$current_theme   = wp_get_theme( $this->slug );
		$current_version = $current_theme->get( 'Version' );

		$payload = array(
			'theme'        => $this->slug,
			'new_version'  => $remote['version'],
			'url'          => $current_theme->get( 'ThemeURI' ),
			'package'      => $remote['download_url'],
			'requires'     => isset( $remote['requires'] ) ? $remote['requires'] : '',
			'requires_php' => isset( $remote['requires_php'] ) ? $remote['requires_php'] : '',
		);

		if ( version_compare( $remote['version'], $current_version, '>' ) ) {
			$transient->response[ $this->slug ] = $payload;
		} else {
			// Already current — listed under no_update so the admin screen
			// can still show where the theme gets its updates from.
			$transient->no_update[ $this->slug ] = $payload;
		}

		return $transient;
	}

	// -------------------------------------------------------------------------
	// themes_api
	// -------------------------------------------------------------------------

	/**
	 * Serve the theme details popup from the remote payload.
	 *
	 * @param false|object|array $result Response from the themes API.
	 * @param string             $action Requested action.
	 * @param object             $args   Request arguments.
	 * @return false|object|array
	 */
	public function theme_info( $result, $action, $args ) {
		if ( 'theme_information' !== $action ) {
			return $result;
		}

		if ( ! isset( $args->slug ) || $args->slug !== $this->slug ) {
			return $result;
		}

		$remote = $this->get_remote_data();

		if ( false === $remote ) {
			return $result;
		}

		$current_theme = wp_get_theme( $this->slug );

		$info                = new stdClass();
		$info->name          = $current_theme->get( 'Name' );
		$info->slug          = $this->slug;
		$info->version       = $remote['version'];
		$info->author        = $current_theme->get( 'Author' );
		$info->homepage      = $current_theme->get( 'ThemeURI' );
		$info->download_link = $remote['download_url'];
		$info->requires      = isset( $remote['requires'] ) ? $remote['requires'] : '';
		$info->requires_php  = isset( $remote['requires_php'] ) ? $remote['requires_php'] : '';
		$info->tested        = isset( $remote['tested'] ) ? $remote['tested'] : '';
		$info->sections      = array(
			'description' => $current_theme->get( 'Description' ),
			'changelog'   => isset( $remote['changelog'] ) ? $remote['changelog'] : '',
		);

		if ( ! empty( $remote['banners'] ) ) {
			$info->banners = $remote['banners'];
		}

		return $info;
	}

	// -------------------------------------------------------------------------
	// Admin: force a fresh check
	// -------------------------------------------------------------------------

	/**
	 * Handle themes.php?linkinbio_force_check={slug} by dropping the
	 * cached payload and redirecting back with a confirmation flag.
	 */
	public function handle_force_check() {
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- the nonce is verified below, once we know the request is ours.
		if ( ! isset( $_GET['linkinbio_force_check'] ) || ! is_string( $_GET['linkinbio_force_check'] ) ) {
			return;
		}

		if ( sanitize_key( wp_unslash( $_GET['linkinbio_force_check'] ) ) !== $this->slug ) {
			return;
		}
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		if ( ! current_user_can( 'update_themes' ) ) {
			wp_die( esc_html__( 'Permission denied.', 'linkinbio' ) );
		}

		check_admin_referer( 'linkinbio_force_check_' . $this->slug );

		// Drop the cache so the next check goes to the server.
		delete_transient( 'linkinbio_updater_' . $this->slug );
		delete_site_transient( 'update_themes' );

		wp_safe_redirect(
			add_query_arg(
				array( 'linkinbio_checked' => $this->slug ),
				remove_query_arg( array( 'linkinbio_force_check', '_wpnonce' ) )
			)
		);
		exit;
	}

	/**
	 * Show the "check for updates now" button on the Themes screen, and
	 * the confirmation notice after it has been used.
	 *
	 * Shown even when the theme is not the active one, so an update can
	 * be pulled in before switching to it.
	 */
	public function show_force_check_notice() {
		$screen = get_current_screen();

		if ( ! $screen || 'themes' !== $screen->id ) {
			return;
		}

		if ( ! current_user_can( 'update_themes' ) ) {
			return;
		}

		$checked = '';

		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- display-only flag set by our own redirect; nothing is written and no action is taken on it.
		if ( isset( $_GET['linkinbio_checked'] ) && is_string( $_GET['linkinbio_checked'] ) ) {
			$checked = sanitize_key( wp_unslash( $_GET['linkinbio_checked'] ) );
		}
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		if ( $checked === $this->slug ) {
			$theme = wp_get_theme( $this->slug );
			$name  = $theme->exists() ? esc_html( $theme->get( 'Name' ) ) : esc_html( $this->slug );

			echo '<div class="notice notice-success is-dismissible"><p>';
			printf(
				/* translators: %s: theme name */
				esc_html__( 'Cleared the cached update information for %s. Any available update is listed below.', 'linkinbio' ),
				'<strong>' . $name . '</strong>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $name is escaped above.
			);
			echo '</p></div>';
			return;
		}

		$theme = wp_get_theme( $this->slug );

		if ( ! $theme->exists() ) {
			return;
		}

		$name = esc_html( $theme->get( 'Name' ) );

		$nonce_url = wp_nonce_url(
			add_query_arg(
				array( 'linkinbio_force_check' => $this->slug ),
				admin_url( 'themes.php' )
			),
			'linkinbio_force_check_' . $this->slug
		);

		echo '<div class="notice notice-info"><p>';
		printf(
			/* translators: 1: theme name, 2: link markup for the check-now button */
			esc_html__( 'Update checks for %1$s are cached for up to one hour. %2$s', 'linkinbio' ),
			'<strong>' . $name . '</strong>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $name is escaped above.
			'<a href="' . esc_url( $nonce_url ) . '" class="button button-small">'
				. esc_html__( 'Check for updates now', 'linkinbio' ) .
			'</a>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from escaped parts.
		);
		echo '</p></div>';
	}

	// -------------------------------------------------------------------------
	// Remote payload
	// -------------------------------------------------------------------------

	/**
	 * Fetch the remote JSON, with caching.
	 *
	 * A successful payload is cached for CACHE_TTL; a failure is cached
	 * as CACHE_FAILURE_SENTINEL in the same transient for CACHE_TTL_FAILURE,
	 * because get_transient() cannot tell "nothing stored" apart from
	 * "false was stored".
	 *
	 * @return array|false Payload array on success, false on failure.
	 */
	private function get_remote_data() {
		if ( null !== $this->remote_data ) {
			return $this->remote_data;
		}

		$cache_key = 'linkinbio_updater_' . $this->slug;
		$cached    = get_transient( $cache_key );

		if ( false !== $cached ) {
			// A failure is stored as the sentinel rather than false — see above.
			$this->remote_data = ( self::CACHE_FAILURE_SENTINEL === $cached ) ? false : $cached;
			return $this->remote_data;
		}

		$url = $this->remote_url;

		// Append the licence key when the theme provides one.
		if ( $this->license_callback && is_callable( $this->license_callback ) ) {
			$license_key = call_user_func( $this->license_callback );

			if ( ! empty( $license_key ) ) {
				$url = add_query_arg( 'license', $license_key, $url );
			}
		}

		$response = wp_remote_get(
			$url,
			array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json',
				),
			)
		);

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			$this->remote_data = false;
			set_transient( $cache_key, self::CACHE_FAILURE_SENTINEL, self::CACHE_TTL_FAILURE );
			return false;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( ! is_array( $data ) || empty( $data['version'] ) || empty( $data['download_url'] ) ) {
			$this->remote_data = false;
			set_transient( $cache_key, self::CACHE_FAILURE_SENTINEL, self::CACHE_TTL_FAILURE );
			return false;
		}

		$this->remote_data = $data;
		set_transient( $cache_key, $data, self::CACHE_TTL );

		return $this->remote_data;
	}
}
