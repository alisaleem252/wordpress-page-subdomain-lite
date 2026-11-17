<?php
/**
 * Plugin Name: Page as Subdomain Lite
 * Description: Convert a single WordPress page into a subdomain (page-name.yoursite.com). Requires a wildcard subdomain DNS record.
 * Plugin URI: https://blog.alisaleem252.com/2024/11/wordpress-page-as-subdomain-lite-plugin.html
 * Version: 2.6.0
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Author: alisaleem252 | Gigsix Studio
 * Author URI: https://alisaleem252.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: page-as-subdomain-lite
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// Do not load twice if another copy of this plugin family is already active.
if ( class_exists( 'PASFsubpageSubdomain' ) ) {
	add_action( 'admin_notices', function () {
		echo '<div class="notice notice-error"><p>' . esc_html__( 'Page as Subdomain Lite cannot run because another Page as Subdomain plugin that uses the same code is already active. Deactivate one of them.', 'page-as-subdomain-lite' ) . '</p></div>';
	} );
	return;
}

define( 'PASF_VERSION', '2.6.0' );
define( 'pageassubdomainPATH', dirname( __FILE__ ) );
define( 'pageassubdomainURL', plugin_dir_url( __FILE__ ) );
define( 'PASF_BASENAME', plugin_basename( __FILE__ ) );

require_once pageassubdomainPATH . '/inc/class.PASFsubpageSubdomain.php';
require_once pageassubdomainPATH . '/inc/class.PASFinitpagePlugin.php';
require_once pageassubdomainPATH . '/inc/init.php';

// Rules are computed at read time (see inc/init.php), so only a one-off flush is needed.
register_activation_hook( __FILE__, 'pasf_flush_rules_once' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
