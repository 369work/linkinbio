<?php
/**
 * LinkInBio Theme Functions
 *
 * @package linkinbio
 */

declare(strict_types=1);

defined( 'ABSPATH' ) || exit;

// =============================================================================
// テーマ定数
// =============================================================================

define( 'LINKINBIO_VERSION', wp_get_theme()->get( 'Version' ) );

// =============================================================================
// テーマ初期設定
// =============================================================================

/**
 * テーマサポートを宣言し、エディタースタイルを登録する。
 *
 * @return void
 */
function linkinbio_setup(): void {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_editor_style( 'assets/css/linkinbio-style.css' );
	add_editor_style( 'assets/css/linkinbio-editor-style.css' );
}
add_action( 'after_setup_theme', 'linkinbio_setup' );

// =============================================================================
// スタイルのエンキュー
// =============================================================================

/**
 * フロントエンド CSS をエンキューする。
 *
 * @return void
 */
function linkinbio_enqueue_styles(): void {
	wp_enqueue_style(
		'linkinbio-theme',
		get_template_directory_uri() . '/style.css',
		array(),
		LINKINBIO_VERSION
	);

	wp_enqueue_style(
		'linkinbio-style',
		get_template_directory_uri() . '/assets/css/linkinbio-style.css',
		array( 'linkinbio-theme' ),
		LINKINBIO_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'linkinbio_enqueue_styles' );

// =============================================================================
// ブロックパターンカテゴリ
// =============================================================================

/**
 * ブロックパターンカテゴリを登録する。
 *
 * パターン本体は /patterns/*.php の各ファイルヘッダー（Title / Slug）から
 * WordPress が自動登録するため、ここではカテゴリのみを登録する。
 *
 * @return void
 */
function linkinbio_register_pattern_category(): void {
	register_block_pattern_category(
		'linkinbio_patterns',
		array(
			'label'       => __( 'LinkInBio Patterns', 'linkinbio' ),
			'description' => __( 'Patterns provided by LinkInBio.', 'linkinbio' ),
			'icon'        => 'admin-links',
		)
	);
}
add_action( 'init', 'linkinbio_register_pattern_category' );

// =============================================================================
// 自動アップデート
// =============================================================================

require_once get_template_directory() . '/inc/class-linkinbio-theme-updater.php';

new LinkInBio_Theme_Updater(
	array(
		'slug'       => 'linkinbio',
		'remote_url' => 'https://369theme.com/releases/linkinbio.json',
	)
);

/**
 * ローカル開発環境（Local / Studio など）でのみ、SSL 証明書の検証を無効化する。
 *
 * @param array<string, mixed> $args リクエスト引数。
 * @param string               $url  リクエスト先 URL。
 * @return array<string, mixed>
 */
if ( in_array( wp_get_environment_type(), array( 'local', 'development' ), true ) ) {
	add_filter(
		'http_request_args',
		function ( array $args, string $url ): array {
			if ( false !== strpos( $url, '369theme.com' ) ) {
				$args['sslverify'] = false;
			}
			return $args;
		},
		10,
		2
	);
}
