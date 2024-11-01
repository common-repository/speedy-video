<?php

/**
 * Settings Tab.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Speedyvideo
 * @subpackage Speedyvideo/includes
 * @author     Rich Agnew <richagnew@rogers.com>
 */


// Settings Tab - START

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

echo '<h3><u>Update Your Speedy Video Settings</u></h3>';

$submitButtonS = sanitize_text_field($_POST['submitButtonS']);
$update_settings_nonce_field = sanitize_text_field($_POST['update_settings_nonce_field']);


if ($submitButtonS == "Update Settings")
{
	if (! wp_verify_nonce( $update_settings_nonce_field, 'update_settings_action'))
	{
		echo 'Sorry, your nonce did not verify.';
		exit();
	}


	// speedy_video_customer_id
		$speedy_video_customer_id = sanitize_text_field($_POST['speedy_video_customer_id']);

		$sql = "UPDATE " . $wpdb->prefix . "options 
			SET option_value = '$speedy_video_customer_id' 
			WHERE option_name = 'speedy_video_customer_id' 
			LIMIT 1";

		$sql = $wpdb->prepare($sql);
		$result = $wpdb->get_results($sql);


	// speedy_video_webkey
		$speedy_video_webkey = sanitize_text_field($_POST['speedy_video_webkey']);

		$sql = "UPDATE " . $wpdb->prefix . "options 
			SET option_value = '$speedy_video_webkey' 
			WHERE option_name = 'speedy_video_webkey' 
			LIMIT 1";

		$sql = $wpdb->prepare($sql);
		$result = $wpdb->get_results($sql);

		echo '<div class="updated notice">';
    	echo '<p>Your Settings Have Been Updated</p>';
		echo '</div>';

}


//Get Values From Dbase.
$sql20 = "SELECT * FROM " . $wpdb->prefix . "options WHERE option_name LIKE 'speedy_video_%' ";
$sql20 = $wpdb->prepare($sql20);

$result20 = $wpdb->get_results($sql20);

foreach($result20 as $value)
{
	$option_id = $value->option_id;
	$option_name = $value->option_name;
	$option_value = $value->option_value;
	$$option_name = $option_value;
}


// If New Account then Display Message
if (!$speedy_video_customer_id || !$speedy_video_webkey)
{
	echo '<p>Thank you for installing the Speedy Video WordPress Plugin.</p>';
	echo '<p>To get started you must first setup a Speedy Video Account. Don\'t worry, its quick and easy and you do <b>not</b> have to put in any form of payment to get started.</p>';
	echo '<p>As an added bonus, we will give you <b>50 Speedy Video Credits</b> that will allow you to start using the system for <b><u>FREE!!</u></b></p>';
	echo '<p><b><u><a href="https://www.speedyvideo.net/accounts.html" title="Speedy Video Sign-Up Page" target="_blank">Click Here To Get Started</a></u></b></p><hr>';
}


echo '<div id="EVSettingsForm">';
echo '<form action="admin.php?page=speedy-video-button-slug" method="post">';
echo '<input type="hidden" value="true" name="speedy_settings_button" />';

echo '<div>';
echo '<div><b>Speedy Video Customer ID:</b></div>';
echo '<div style="padding-top:5px;"><input name="speedy_video_customer_id" type="number" value="' . $speedy_video_customer_id . '" maxlength="10" size="50" required></div>';
echo '</div>';

echo '<br>';
echo '<div>';
echo '<div><b>Speedy Video Web Key:</b></div>';
echo '<div style="padding-top:5px;"><input name="speedy_video_webkey" type="text" value="' . $speedy_video_webkey . '" maxlength="255" size="85" required></div>';
echo '</div>';

echo '<p class="submit"><input type="submit" name="submitButtonS" id="submitButtonS" class="button button-primary" value="Update Settings"  /></p>';

wp_nonce_field( 'update_settings_action', 'update_settings_nonce_field' );

echo '</form>';
echo '</div>';

// Settings Tab - FINI