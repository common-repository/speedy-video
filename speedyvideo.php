<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.speedyvideo.net
 * @since             1.0.0
 * @package           Speedyvideo
 *
 * @wordpress-plugin
 * Plugin Name:       Speedy Video
 * Plugin URI:        https://www.speedyvideo.net/
 * Description:       Speedy Video allows you to quickly and easily make a page or post video. You can upload that video to YouTube.
 * Version:           1.0.2
 * Author:            Speedy Video
 * Author URI:        https://www.computer-geek.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       speedyvideo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


define( 'SPEEDY_VIDEO_PLUGIN_NAME_VERSION', '1.0.2' );

// Speedy Video Start

add_action('admin_menu', 'speedy_video_button_menu');

function speedy_video_button_menu()
{
 	add_menu_page('Speedy Video', 'Speedy Video', 'manage_options', 'speedy-video-button-slug', 'speedy_video_button_admin_page', plugins_url("speedy-video/admin/images/icon-32x32.png"));
	add_submenu_page( 'speedy-video-button-slug', 'Simple Video', 'Simple Video', 'manage_options', 'admin.php?page=speedy-video-button-slug&tab=create_simple_video', $function);
	add_submenu_page( 'speedy-video-button-slug', 'Advanced Video', 'Advanced Video', 'manage_options', 'admin.php?page=speedy-video-button-slug&tab=create_advanced_video', $function);
	add_submenu_page( 'speedy-video-button-slug', 'Template Samples', 'Template Samples', 'manage_options', 'admin.php?page=speedy-video-button-slug&tab=template_samples', $function);	
	add_submenu_page( 'speedy-video-button-slug', 'Video Samples', 'Video Samples', 'manage_options', 'admin.php?page=speedy-video-button-slug&tab=video_samples', $function);	
	add_submenu_page( 'speedy-video-button-slug', 'News', 'News', 'manage_options', 'admin.php?page=speedy-video-button-slug&tab=news', $function);	
}

function speedy_video_button_admin_page() 
{
	global $wpdb;

  // This function creates the output for the admin page.
  // It also checks the value of the $_POST variable to see whether
  // there has been a form submission. 

  // The check_admin_referer is a WordPress function that does some security
  // checking and is recommended good practice.

  // General check for user permissions.
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient pilchards to access this page.')    );
  }

  // Start building the page


	//Check for CustomID & WebKey
	$sql20 = "SELECT * FROM wp_options WHERE option_name LIKE 'speedy_video_%' ";
	$sql20 = $wpdb->prepare($sql20);

	$result20 = $wpdb->get_results($sql20);

	foreach($result20 as $value)
	{
		$option_id = $value->option_id;
		$option_name = $value->option_name;
		$option_value = $value->option_value;
		$$option_name = $option_value;
	}

	//echo "[$speedy_video_customer_id]";
	//echo "[$speedy_video_webkey]";


  echo '<div class="wrap">';

  	echo '<h2>Speedy Video Dashboard</h2>';
	echo '<br>';

	echo '<div style="float: left; width:70%; padding:5px; border-style:solid; border-width:1px; border-color: #DEDBD1;" id="speed-video-main-div">';

  	echo '<div class="wrap">';  
  	echo '<div id="icon-themes" class="icon32"></div>';

	settings_errors();  
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'settings';  

	$redirect = $_GET[ 'redirect' ];
	if ($redirect == 'buy_credits' || $redirect == 'update_credits')
	{
		//Send to Speedy Video Site after resetting date.
		$sql = "UPDATE 
					wp_options 
				SET option_value = '' 
				WHERE option_name = 'speedy_video_credit_update' 
				LIMIT 1";

		$sql = $wpdb->prepare($sql);

		$result = $wpdb->get_results($sql);

		if ($redirect == 'buy_credits')
		{
			echo '<script LANGUAGE="JavaScript">';
			echo 'location = "https://www.speedyvideo.net/accounts.html"';
			echo '</script>';
			exit();
		}

	}


	echo '<h2 class="nav-tab-wrapper">';
	?>

	<a href="admin.php?page=speedy-video-button-slug&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
	<a href="admin.php?page=speedy-video-button-slug&tab=create_simple_video" class="nav-tab <?php echo $active_tab == 'create_simple_video' ? 'nav-tab-active' : ''; ?>">Simple Video</a>
	<a href="admin.php?page=speedy-video-button-slug&tab=create_advanced_video" class="nav-tab <?php echo $active_tab == 'create_advanced_video' ? 'nav-tab-active' : ''; ?>">Advanced Video</a>
	<a href="admin.php?page=speedy-video-button-slug&tab=template_samples" class="nav-tab <?php echo $active_tab == 'template_samples' ? 'nav-tab-active' : ''; ?>">Template Samples</a>
	<a href="admin.php?page=speedy-video-button-slug&tab=video_samples" class="nav-tab <?php echo $active_tab == 'video_samples' ? 'nav-tab-active' : ''; ?>">Video Samples</a>
	<a href="admin.php?page=speedy-video-button-slug&tab=news" class="nav-tab <?php echo $active_tab == 'news' ? 'nav-tab-active' : ''; ?>">News</a>

	<?php
	echo '</h2>';

	$dir = plugin_dir_url( __FILE__ );

    if( $active_tab == 'settings' ) 
	{  
		// Settings Tab - START
		require_once plugin_dir_path( __FILE__ ) . 'includes/update-settings.php';
		// Settings Tab - FINI

    } else if( $active_tab == 'create_simple_video' ) 
	{
		// Simple Video Tab - START
		require_once plugin_dir_path( __FILE__ ) . 'includes/simple-video.php';
		// Simple Video Tab - FINI
    } else if( $active_tab == 'create_advanced_video' ) 
	{
		// Advanced Video Tab - START
		require_once plugin_dir_path( __FILE__ ) . 'includes/advanced-video.php';
		// Advanced Video Tab - FINI
    } else if( $active_tab == 'template_samples' ) 
	{
		// Template Samples Tab - START
		require_once plugin_dir_path( __FILE__ ) . 'includes/template-samples.php';
		// Template Samples Tab - FINI

    } else if( $active_tab == 'video_samples' ) 
	{
		// Video Samples Tab - START
		require_once plugin_dir_path( __FILE__ ) . 'includes/samples.php';
		// Video Samples Tab - FINI
    } else if( $active_tab == 'news' ) 
	{
		// News Tab - START
		require_once plugin_dir_path( __FILE__ ) . 'includes/news.php';
		// News Tab - FINI
	}

	echo '</div>';
	echo '</div>';

	echo '<div style="float:left; width:250px; padding-left:10px;" id="speed-video-ad-div">';

	// Right Column - START
		require_once plugin_dir_path( __FILE__ ) . 'includes/right-column.php';
	// Right Column - Fini

	echo '</div>';
	echo '<div style="clear: both;"></div>';


	echo '<div id="speed-video-footer-ad-div" style="padding-top: 15px;" align="center">';

	// Footer Ad - START
		require_once plugin_dir_path( __FILE__ ) . 'includes/footer-ads.php';
	// Footer Ad - Fini

	echo '</div>';


// Speedy Video Fini

}



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-speedyvideo-activator.php
 */
function activate_speedyvideo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-speedyvideo-activator.php';
	Speedyvideo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-speedyvideo-deactivator.php
 */
function deactivate_speedyvideo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-speedyvideo-deactivator.php';
	Speedyvideo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_speedyvideo' );
register_deactivation_hook( __FILE__, 'deactivate_speedyvideo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-speedyvideo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_speedyvideo() {

	$plugin = new Speedyvideo();
	$plugin->run();

}
run_speedyvideo();
