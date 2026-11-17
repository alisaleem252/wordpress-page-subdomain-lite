<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Registers the front-end hooks of the plugin.
 */
class PASFinitpagePlugin extends PASFsubpageSubdomain {

	function __construct() {
		parent::__construct();
	}

	function addpageFilters() {
		// Subdomain rules are injected when WordPress reads or regenerates the rules, and never saved.
		add_filter( 'option_rewrite_rules', 'pasf_inject_rules' );
		add_filter( 'rewrite_rules_array', 'pasf_inject_rules', 99 );
		add_filter( 'pre_update_option_rewrite_rules', 'pasf_strip_rules' );
		add_filter( 'page_link', 'pasf_page_link', 100, 2 );
	}
}
