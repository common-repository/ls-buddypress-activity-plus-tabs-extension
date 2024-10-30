<?php
/**
Plugin Name: LS Buddypress Activity plus tabs extension
PLugin URI: https://lenasterg.wordpress.com/
Description: Extends the functionality of Activity Plus Reloaded for BuddyPress plugin by adding related tabs and widgets in each group.
Version: 4.0
Revision Date: January 27, 2023
Requires at least: WP 4.3
Requires Plugins: buddypress, bp-activity-plus-reloaded
Tested up to: WP 6.1.1
License:  GNU General Public License 3.0 or newer (GPL) http://www.gnu.org/licenses/gpl.html
Author: Lena Stergatou, NTS on cti.gr
Author URI: https://lenasterg.wordpress.com
*/



/**
 * Only load code that needs BuddyPress to run once BP is loaded and initialized.
 * @global type $wpdb
 * @return type
 *
 * @version 3, 26/1/2023
 */
function ls_bpfp_loader() {
	global $wpdb;
	if ( is_multisite() && BP_ROOT_BLOG !== $wpdb->blogid ) {
		return;
	}
	if ( ! bp_is_active( 'groups' ) ) {
		return;
	}
	if ( ! is_buddypress_activity_plus_active() ) {
		return;
	} else {
		add_action( 'widgets_init', 'ls_bpfb_register_widgets' );
		/**
		 * @since 4.0
		 */
		add_action( 'bp_late_include', 'ls_bpfp_tabs_init', 1000 );
		add_action( 'wp_enqueue_scripts', 'ls_bpfp_front_cssjs' );
	}
}

add_action( 'bp_register_widgets', 'ls_bpfp_loader' );



/**
 * Loads the tabs
 *
 * @since 4.0
 *
 */
function ls_bpfp_tabs_init() {
	if ( bp_is_group() ) {
			$dir   = dirname( __FILE__ );
		
		$bpfc_data= BPAPR_Data::get( 'allowed_items', array( 'photos', 'videos', 'links' ) );
	
		/**Filters the allowed items widgets to be available
			*
			* @param array  $bpfc_data['allowed_items'].  The allowed_items from the Activity Plus Reloaded for BuddyPress plugin.
			* @since 4.0
			*/
		$allowed_tabs = apply_filters( 'ls_bpfb_allowed_tabs', $bpfc_data );

		foreach ( $allowed_tabs as $value ) {
			if ( 'photos' === $value ) {
				$value = 'images';
			}
			if ( file_exists( $dir . '/lib/class-ls-bpfb-' . $value . '-tab-extension.php' ) ) {
				require_once( $dir . '/lib/class-ls-bpfb-' . $value . '-tab-extension.php' );
				bp_register_group_extension( 'LS_BPFB_' . ucwords( $value ) . '_Tab_Extension' );
			}
		}
	}
}
/**
 * @version 2, 27/8/2013, fixed for site_wide installed buddypress-activity-plus
 * @return boolean
 */
function is_buddypress_activity_plus_active() {
	if ( ( in_array( 'bp-activity-plus-reloaded/bp-activity-plus-reloaded.php', (array) get_option( 'active_plugins', array() ) ) ) || ( ( in_array( 'buddypress-activity-plus/bpfb.php', (array) get_option( 'active_plugins', array() ) ) ) ) ) {
		return true;
	} else {
		if ( ( array_key_exists( 'bp-activity-plus-reloaded/bp-activity-plus-reloaded.php', (array) get_site_option( 'active_sitewide_plugins' ) ) ) || ( array_key_exists( 'buddypress-activity-plus/bpfb.php', (array) get_site_option( 'active_sitewide_plugins' ) ) ) ) {
			return true;
		}
	}
	return false;
}


/**
 * Register the LS_BPFB widgets.
 * @version 2, 22/4/2014
 */
function ls_bpfb_register_widgets() {
	if ( ! bp_is_active( 'groups' ) ) {
		return;
	}
	// The LS_BPFB_links widget works only when looking at a group page,
	// and the concept of "current group " doesn't exist on non-root blogs,
	// so we don't register the widget there.
	if ( ! bp_is_root_blog() ) {
		return;
	}
	$dir       = dirname( __FILE__ );
	$bpfc_data= BPAPR_Data::get( 'allowed_items', array( 'photos', 'videos', 'links' ) );
	
	/**Filters the allowed items widgets to be available
	*
	* @param array  $bpfc_data['allowed_items'].  The allowed_items from the Activity Plus Reloaded for BuddyPress plugin.
	* @since 4.0
	*/
	$allowed_widgets = apply_filters( 'ls_bpfb_allowed_widgets', $bpfc_data );

	foreach ( $allowed_widgets as $value ) {
		if ( 'photos' === $value ) {
				$value = 'images';
		}
		if ( file_exists( $dir . '/lib/class-ls-bpfb-current-group-' . $value . '-widget.php' ) ) {
			require_once( $dir . '/lib/class-ls-bpfb-current-group-' . $value . '-widget.php' );
			register_widget( 'LS_BPFB_Current_Group_' . ucwords( $value ) . '_Widget' );
		}
	}

}


/**
 *
 * This function will enqueue the components CSS and JavaScript files
 * only when the front group  page is displayed
 */
function ls_bpfp_front_cssjs() {
	$bp = buddypress();
	//if we're on a group page
	if ( $bp->current_component === $bp->groups->slug ) {
		if ( ! current_theme_supports( 'ls_bpfb_style' ) ) {
			wp_register_style( 'ls_bpfb', plugin_dir_url(__FILE__) . '/css/style.css' );
			wp_enqueue_style( 'ls_bpfb' );
		}
	}
}
