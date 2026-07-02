<?php
/**
 * LinkInBio Theme Self-Hosted Updater
 *
 * @package linkinbio
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'LinkInBio_Theme_Updater' ) ) {
	return;
}

/**
 * Theme updater class for self-hosted theme updates.
 *
 * Handles checking for theme updates from a remote JSON source and
 * integrating update information into WordPress theme update mechanisms.
 *
 * @package linkinbio
 */
class LinkInBio_Theme_Updater {


	/**
	 * Theme slug (directory name).
	 *
	 * @var string テーマスラッグ（ディレクトリ名）
	 */
	private string $slug;

	/**
	 * Remote JSON URL for update information.
	 *
	 * @var string リモート JSON の URL
	 */
	private string $remote_url;

	/**
	 * Cached remote data.
	 *
	 * @var array|false|null キャッシュ済みリモートデータ
	 */
	private $remote_data = null;

	/**
	 * Constructor.
	 *
	 * @param array $args {
	 *     Arguments for the updater.
	 *
	 *     @type string $slug       Theme slug (directory name).
	 *     @type string $remote_url Remote JSON URL for update information.
	 * }
	 */
	public function __construct( array $args ) {
		$this->slug       = isset( $args['slug'] ) ? (string) $args['slug'] : '';
		$this->remote_url = isset( $args['remote_url'] ) ? (string) $args['remote_url'] : '';

		add_filter( 'site_transient_update_themes', array( $this, 'check_update' ) );
		add_filter( 'themes_api', array( $this, 'theme_info' ), 20, 3 );
	}

	/**
	 * Update_themes トランジェントにリモートバージョン情報を注入する。
	 *
	 * @param mixed $transient The transient value.
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

		if ( version_compare( $remote['version'], $current_version, '>' ) ) {
			$transient->response[ $this->slug ] = array(
				'theme'        => $this->slug,
				'new_version'  => $remote['version'],
				'url'          => $current_theme->get( 'ThemeURI' ),
				'package'      => $remote['download_url'],
				'requires'     => $remote['requires'] ?? '',
				'requires_php' => $remote['requires_php'] ?? '',
			);
		} else {
			$transient->no_update[ $this->slug ] = array(
				'theme'        => $this->slug,
				'new_version'  => $remote['version'],
				'url'          => $current_theme->get( 'ThemeURI' ),
				'package'      => $remote['download_url'],
				'requires'     => $remote['requires'] ?? '',
				'requires_php' => $remote['requires_php'] ?? '',
			);
		}

		return $transient;
	}

	/**
	 * テーマ詳細ポップアップ（themes_api）にリモート情報を返す。
	 *
	 * @param false|object|array $result The API response object or false.
	 * @param string             $action The API action being performed.
	 * @param object             $args   The API arguments.
	 * @return false|object
	 */
	public function theme_info( $result, string $action, object $args ) {
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
		$info->requires      = $remote['requires'] ?? '';
		$info->requires_php  = $remote['requires_php'] ?? '';
		$info->tested        = $remote['tested'] ?? '';
		$info->sections      = array(
			'description' => $current_theme->get( 'Description' ),
			'changelog'   => $remote['changelog'] ?? '',
		);

		if ( ! empty( $remote['banners'] ) ) {
			$info->banners = $remote['banners'];
		}

		return $info;
	}

	/**
	 * リモート JSON を取得してキャッシュする。
	 *
	 * 12 時間のトランジェントキャッシュを使い、サーバーへの負荷を抑える。
	 *
	 * @return array|false 成功時は連想配列、失敗時は false。
	 */
	private function get_remote_data() {
		if ( null !== $this->remote_data ) {
			return $this->remote_data;
		}

		$cache_key = 'linkinbio_updater_' . $this->slug;
		$cached    = get_transient( $cache_key );

		if ( false !== $cached ) {
			if ( ! is_array( $cached ) ) {
				// '_failed' 番兵値、または壊れたキャッシュ → 失敗として返す。
				$this->remote_data = false;
				return false;
			}
			$this->remote_data = $cached;
			return $this->remote_data;
		}

		$url = $this->remote_url;

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
			set_transient( $cache_key, '_failed', HOUR_IN_SECONDS );
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( ! is_array( $data ) || empty( $data['version'] ) || empty( $data['download_url'] ) ) {
			$this->remote_data = false;
			set_transient( $cache_key, '_failed', HOUR_IN_SECONDS );
			return false;
		}

		$this->remote_data = $data;
		set_transient( $cache_key, $data, 12 * HOUR_IN_SECONDS );

		return $this->remote_data;
	}
}
