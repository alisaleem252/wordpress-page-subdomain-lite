<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ------------------------------------------------------------------
 * Helpers
 * ---------------------------------------------------------------- */

/**
 * ID of the page chosen in the settings (0 when none). The option is stored
 * as an array whose first item is the ID, or "no" when nothing is selected.
 */
function pasf_selected_page_id() {
	$saved = get_option( 'pages_subdomain' );
	$id    = ( is_array( $saved ) && isset( $saved[0] ) ) ? absint( $saved[0] ) : 0;
	return $id;
}

/**
 * Slug of the selected page, or '' when there is no valid published page.
 */
function pasf_selected_slug() {
	static $cache = array();
	$id = pasf_selected_page_id();
	if ( ! $id ) {
		return '';
	}
	if ( ! isset( $cache[ $id ] ) ) {
		$page         = get_post( $id );
		$cache[ $id ] = ( $page && 'page' === $page->post_type && 'publish' === $page->post_status ) ? $page->post_name : '';
	}
	return $cache[ $id ];
}

/**
 * True when the current request is for slug.yoursite.com of the selected page.
 */
function pasf_on_subdomain() {
	static $result = null;
	if ( null !== $result ) {
		return $result;
	}
	$result = false;
	$slug   = pasf_selected_slug();
	if ( '' === $slug || empty( $_SERVER['HTTP_HOST'] ) ) {
		return $result;
	}
	$request_host = strtolower( preg_replace( '/:\d+$/', '', wp_unslash( $_SERVER['HTTP_HOST'] ) ) );
	$site_host    = strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
	$site_host    = preg_replace( '/^www\./', '', $site_host );
	$result       = ( '' !== $site_host && $request_host === $slug . '.' . $site_host );
	return $result;
}

/**
 * Rewrite rules used on the page subdomain. Built locally, nothing is fetched.
 */
function pasf_subdomain_rules( $slug ) {
	$base     = 'index.php?pagename=' . $slug;
	$reserved = '(?!wp-json/|wp-json$|wp-admin|wp-content|wp-includes|wp-login)';
	return array(
		'trackback/?$'                           => $base . '&tb=1',
		'feed/(feed|rdf|rss|rss2|atom)/?$'       => $base . '&feed=$matches[1]',
		'(feed|rdf|rss|rss2|atom)/?$'            => $base . '&feed=$matches[1]',
		'page/?([0-9]{1,})/?$'                   => $base . '&paged=$matches[1]',
		'comment-page-([0-9]{1,})/?$'            => $base . '&cpage=$matches[1]',
		'wc-api(/(.*))?/?$'                      => $base . '&wc-api=$matches[2]',
		'$'                                      => $base,
		$reserved . '([^/]+)/?$'                 => $base . '/$matches[1]',
		$reserved . '([^/]+)/([^/]+)/?$'         => $base . '/$matches[1]/$matches[2]',
		$reserved . '([^/]+)/([^/]+)/([^/]+)/?$' => $base . '/$matches[1]/$matches[2]/$matches[3]',
	);
}

/* ------------------------------------------------------------------
 * Rewrite rules: injected when WordPress reads them, only on the subdomain.
 * Nothing is written to the database and nothing is flushed per request.
 * ---------------------------------------------------------------- */
function pasf_inject_rules( $rules ) {
	if ( empty( $rules ) || ! is_array( $rules ) || ! pasf_on_subdomain() ) {
		return $rules;
	}
	return pasf_subdomain_rules( pasf_selected_slug() ) + $rules;
}

/**
 * Never let subdomain rules reach the stored rules: if rules are regenerated
 * while on the subdomain (other plugins clear them), they would otherwise be
 * saved and then break the main site.
 */
function pasf_strip_rules( $rules ) {
	$slug = pasf_selected_slug();
	if ( '' === $slug || ! is_array( $rules ) ) {
		return $rules;
	}
	foreach ( pasf_subdomain_rules( $slug ) as $regex => $query ) {
		if ( isset( $rules[ $regex ] ) && $rules[ $regex ] === $query ) {
			unset( $rules[ $regex ] );
		}
	}
	return $rules;
}
/**
 * Turns links to the selected page (and its children) into subdomain links.
 */
function pasf_page_link( $link, $id ) {
	if ( is_admin() ) {
		return $link;
	}
	$selected = pasf_selected_page_id();
	$slug     = pasf_selected_slug();
	if ( ! $selected || '' === $slug ) {
		return $link;
	}
	$id = (int) $id;
	if ( $id !== $selected && ! in_array( $selected, get_post_ancestors( $id ), true ) ) {
		return $link;
	}
	$parts = wp_parse_url( $link );
	if ( empty( $parts['host'] ) || empty( $parts['scheme'] ) ) {
		return $link;
	}
	$path   = isset( $parts['path'] ) ? $parts['path'] : '/';
	$prefix = '/' . $slug;
	if ( $path !== $prefix && 0 !== strpos( $path, $prefix . '/' ) ) {
		return $link; // Not a root install, or already rewritten.
	}
	$new_path = substr( $path, strlen( $prefix ) );
	if ( '' === $new_path ) {
		$new_path = '/';
	}
	$host = preg_replace( '/^www\./i', '', $parts['host'] );
	$url  = $parts['scheme'] . '://' . $slug . '.' . $host;
	if ( ! empty( $parts['port'] ) ) {
		$url .= ':' . $parts['port'];
	}
	$url .= $new_path;
	if ( isset( $parts['query'] ) ) {
		$url .= '?' . $parts['query'];
	}
	if ( isset( $parts['fragment'] ) ) {
		$url .= '#' . $parts['fragment'];
	}
	return $url;
}

/**
 * One-off rewrite flush after install or update, so rules saved by older
 * versions (which could contain subdomain rules) are replaced.
 */
function pasf_flush_rules_once() {
	update_option( 'pasf_version', PASF_VERSION );
	flush_rewrite_rules( false );
}
add_action( 'init', function () {
	if ( get_option( 'pasf_version' ) !== PASF_VERSION ) {
		pasf_flush_rules_once();
	}
}, 99 );

/* ------------------------------------------------------------------
 * "More addons" screen: install and activate other plugins
 * ---------------------------------------------------------------- */

/** Plugins that may be installed from the addons screen (slug => main file). */
function pasf_allowed_addons() {
	return array(
		'post-as-subdomain-free' => 'post-as-subdomain-free/post.php',
		'ai-text-block'          => 'ai-text-block/rapidtext-ai-text-block.php',
	);
}

add_action( 'wp_ajax_install_plugin_ajax', 'pageassubdomain_handle_plugin_installation' );

function pageassubdomain_handle_plugin_installation() {
	if ( ! check_ajax_referer( 'install_plugin_nonce', 'nonce', false ) ) {
		wp_send_json_error( __( 'Security check failed. Reload the page and try again.', 'page-as-subdomain-lite' ), 403 );
	}
	if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) ) {
		wp_send_json_error( __( 'You do not have permission to install plugins.', 'page-as-subdomain-lite' ), 403 );
	}

	$allowed = pasf_allowed_addons();
	$slug    = isset( $_POST['plugin_slug'] ) ? sanitize_key( wp_unslash( $_POST['plugin_slug'] ) ) : '';
	if ( ! isset( $allowed[ $slug ] ) ) {
		wp_send_json_error( __( 'This plugin cannot be installed from here.', 'page-as-subdomain-lite' ), 400 );
	}
	$plugin_file = $allowed[ $slug ];

	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/misc.php';

	if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {
		$api = plugins_api( 'plugin_information', array(
			'slug'   => $slug,
			'fields' => array( 'sections' => false ),
		) );
		if ( is_wp_error( $api ) ) {
			wp_send_json_error( __( 'Plugin not found in the WordPress.org repository.', 'page-as-subdomain-lite' ) );
		}
		$skin     = new WP_Ajax_Upgrader_Skin();
		$upgrader = new Plugin_Upgrader( $skin );
		$result   = $upgrader->install( $api->download_link );
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( sprintf( __( 'Installation failed: %s', 'page-as-subdomain-lite' ), $result->get_error_message() ) );
		}
		if ( ! $result ) {
			$errors = $skin->get_errors();
			$msg    = ( is_wp_error( $errors ) && $errors->has_errors() ) ? $errors->get_error_message() : __( 'The plugin could not be installed. Check file permissions.', 'page-as-subdomain-lite' );
			wp_send_json_error( sprintf( __( 'Installation failed: %s', 'page-as-subdomain-lite' ), $msg ) );
		}
	}

	$activated = activate_plugin( $plugin_file );
	if ( is_wp_error( $activated ) ) {
		wp_send_json_error( sprintf( __( 'Plugin installed but activation failed: %s', 'page-as-subdomain-lite' ), $activated->get_error_message() ) );
	}

	wp_send_json_success( __( 'Plugin installed and activated successfully.', 'page-as-subdomain-lite' ) );
}

add_action( 'wp_ajax_check_plugin_status', 'pageassubdomain_handle_check_plugin_status' );

function pageassubdomain_handle_check_plugin_status() {
	if ( ! check_ajax_referer( 'check_plugin_nonce', 'nonce', false ) ) {
		wp_send_json_error( __( 'Security check failed.', 'page-as-subdomain-lite' ), 403 );
	}
	if ( ! current_user_can( 'activate_plugins' ) ) {
		wp_send_json_error( __( 'You do not have permission.', 'page-as-subdomain-lite' ), 403 );
	}
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	$plugin_file = isset( $_POST['plugin_file'] ) ? sanitize_text_field( wp_unslash( $_POST['plugin_file'] ) ) : '';
	if ( ! in_array( $plugin_file, pasf_allowed_addons(), true ) ) {
		wp_send_json_error( __( 'Unknown plugin.', 'page-as-subdomain-lite' ), 400 );
	}

	wp_send_json_success( array(
		'installed' => file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ),
		'active'    => is_plugin_active( $plugin_file ),
	) );
}

/* ------------------------------------------------------------------
 * Plugins screen link
 * ---------------------------------------------------------------- */
add_filter( 'plugin_row_meta', 'pageassubdomain_plugin_row_meta', 10, 2 );

function pageassubdomain_plugin_row_meta( $links, $file ) {
	if ( PASF_BASENAME === $file ) {
		$links[] = '<a href="https://webostock.com/market-item/wordpress-page-as-subdomain-pro/8860/" target="_blank" rel="noopener">' . esc_html__( 'Get Pro', 'page-as-subdomain-lite' ) . '</a>';
	}
	return $links;
}

/* ------------------------------------------------------------------
 * Boot
 * ---------------------------------------------------------------- */
$GLOBALS['pasf_page_plugin'] = new PASFinitpagePlugin();
$GLOBALS['pasf_page_plugin']->addpageFilters();
