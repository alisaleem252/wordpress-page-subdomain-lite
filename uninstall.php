<?php
/**
 * Runs when the plugin is deleted from the Plugins screen.
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'pages_subdomain' );
delete_option( 'pasf_version' );
delete_option( 'pagessubdomain_donottrack' );
delete_option( 'pagessubdomain_subscribe_newsletter' );
delete_option( 'pagessubdomain_subscribed_email' );

flush_rewrite_rules( false );
