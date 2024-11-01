<?php

/**
 * Fired during plugin activation
 *
 * @link       www.speedyvideo.net
 * @since      1.0.0
 *
 * @package    Speedyvideo
 * @subpackage Speedyvideo/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Speedyvideo
 * @subpackage Speedyvideo/includes
 * @author     Rich Agnew <richagnew@rogers.com>
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Speedyvideo_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;


		//Check and set up speedy_video_customer_id
		$sql01 = "SELECT option_name FROM " . $wpdb->prefix . "options WHERE option_name = 'speedy_video_customer_id' LIMIT 1";
		$sql01 = $wpdb->prepare($sql01);
		$result01 = $wpdb->get_results($sql01);
		$NumberRows01 = mysql_num_rows($result01);

		if (!$NumberRows01) 
		{
			$sql10 = "INSERT INTO `" . $wpdb->prefix . "options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES (NULL, 'speedy_video_customer_id', '', 'yes')";
			$sql10 = $wpdb->prepare($sql10);
			$result10 = $wpdb->get_results($sql10);
		}


		//Check and set up speedy_video_webkey
		$sql02 = "SELECT option_name FROM " . $wpdb->prefix . "options WHERE option_name = 'speedy_video_webkey' LIMIT 1";
		$sql02 = $wpdb->prepare($sql02);
		$result02 = $wpdb->get_results($sql02);
		$NumberRows02 = mysql_num_rows($result02);

		if (!$NumberRows02) 
		{
			$sql20 = "INSERT INTO `" . $wpdb->prefix . "options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES (NULL, 'speedy_video_webkey', '', 'yes')";
			$sql20 = $wpdb->prepare($sql20);
			$result20 = $wpdb->get_results($sql20);
		}


		//Check and set up speedy_video_credits
		$sql03 = "SELECT option_name FROM " . $wpdb->prefix . "options WHERE option_name = 'speedy_video_credits' LIMIT 1";
		$sql03 = $wpdb->prepare($sql03);
		$result03 = $wpdb->get_results($sql03);
		$NumberRows03 = mysql_num_rows($result03);

		if (!$NumberRows03) 
		{
			$sql30 = "INSERT INTO `" . $wpdb->prefix . "options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES (NULL, 'speedy_video_credits', '0', 'yes')";
			$sql30 = $wpdb->prepare($sql30);
			$result30 = $wpdb->get_results($sql30);
		}


		//Check and set up speedy_video_update
		$sql04 = "SELECT option_name FROM " . $wpdb->prefix . "options WHERE option_name = 'speedy_video_credit_update' LIMIT 1";
		$sql04 = $wpdb->prepare($sql04);
		$result04 = $wpdb->get_results($sql04);
		$NumberRows04 = mysql_num_rows($result04);

		if (!$NumberRows04) 
		{
			$sql40 = "INSERT INTO `" . $wpdb->prefix . "options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES (NULL, 'speedy_video_credit_update', 'N/A', 'yes')";
			$sql40 = $wpdb->prepare($sql40);
			$result40 = $wpdb->get_results($sql40);
		}

	}

}
