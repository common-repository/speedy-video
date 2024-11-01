<?php

/**
 * Update Credits
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Speedyvideo
 * @subpackage Speedyvideo/includes
 * @author     Rich Agnew <richagnew@rogers.com>
 */


// Update Credits - START

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$CurrentDateTime = date("Y-m-d H:i:s");
$CurrentDateTimeS = date('U', strtotime($CurrentDateTime));
$speedy_video_credit_updateS = date('U', strtotime($speedy_video_credit_update));
$TimeSinceLastUpdate = $CurrentDateTimeS - $speedy_video_credit_updateS;


//If time since last update is greater than one day.
if ($TimeSinceLastUpdate > 86400)
{
	//Contact server to update credits
	$url = 'https://www.speedyvideo.net/UpdateCredits.php';
	$SubmitButton = "Update Credits";

	$fieldsEV = array(
	'CustomerID' => $speedy_video_customer_id,
	'WebKey' => $speedy_video_webkey,
	'SubmitButton' => $SubmitButton
	);


	$arg = array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'body' => $fieldsEV,
			'cookies' => array()
    );



	$result = wp_remote_post( $url, $arg );

	$ResultParsed = $result['body'];


	if ($ResultParsed != "Failed" && $ResultParsed)
	{

		$speedy_video_credits = $ResultParsed;
		$speedy_video_credit_update = $CurrentDateTime;

		$sql10 = "UPDATE 
					" . $wpdb->prefix . "options 
				SET option_value = '$ResultParsed' 
				WHERE option_name = 'speedy_video_credits' 
				LIMIT 1";

		$sql10 = $wpdb->prepare($sql10);

		$result10 = $wpdb->get_results($sql10);


		$sql10 = "UPDATE 
					" . $wpdb->prefix . "options 
				SET option_value = '$CurrentDateTime' 
				WHERE option_name = 'speedy_video_credit_update' 
				LIMIT 1";

		$sql10 = $wpdb->prepare($sql10);

		$result10 = $wpdb->get_results($sql10);

		


		echo '<div class="updated notice">';
    	echo '<p>Your Credit Update Succeeded.</p>';
		echo '</div>';


	} else {

		$sql10 = "UPDATE 
					" . $wpdb->prefix . "options 
				SET option_value = '$CurrentDateTime' 
				WHERE option_name = 'speedy_video_credit_update' 
				LIMIT 1";

		$sql10 = $wpdb->prepare($sql10);

		$result10 = $wpdb->get_results($sql10);

		echo '<div class="updated notice">';
    	echo '<p>Your Credit Update Failed.</p>';
		echo '</div>';
	}



}
// Update Credits - FINI