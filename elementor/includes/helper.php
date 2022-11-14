<?php
/**
 *
 * Ayyash Addons Elementor Helper Functions
 *
 */


/**
 * Determines whether a plugin is active.
 *
 * @param string $plugin Path to the plugin file relative to the plugins directory.
 *
 * @return bool True, if in the active plugins list. False, not in the list.
 * @uses is_plugin_active()
 */
function ayyash_addons_is_plugin_active( $plugin ) {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	return is_plugin_active( $plugin );
}

/**
 * @param $slug
 *
 * @return string|null
 */

function ayyash_addons_plugin_install_url( $slug ) {
	return admin_url( 'plugin-install.php?s=' . $slug . '&tab=search&type=term&ayyash_addons_dependency=' . $slug );
}
