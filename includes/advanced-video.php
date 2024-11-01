<?php

/**
 * Advanced Video Tab.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Speedyvideo
 * @subpackage Speedyvideo/includes
 * @author     Rich Agnew <richagnew@rogers.com>
 */

// Advanced Video Tab - START

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (!$speedy_video_customer_id || !$speedy_video_webkey)
{
	echo '<p>Thank you for installing the Speedy Video WordPress Plugin.</p>';
	echo '<p>To get started you must first setup a Speedy Video Account. Don\'t worry, its quick and easy and you do <b>not</b> have to put in any form of payment to get started.</p>';
	echo '<p>As an added bonus, we will give you <b>50 Speedy Video Credits</b> that will allow you to start using the system for <b><u>FREE!!</u></b></p>';
	echo '<p><b><u><a href="https://www.speedyvideo.net/accounts.html" title="Speedy Video Sign-Up Page" target="_blank">Click Here To Get Started</a></u></b></p><hr>';
}

echo '<h2><u>Create a Advanced Video</u></h2>';
		
echo '<p>An Advanced Video is similar to the Simple Video but you are able to match your photos to a block of spoken text.</p>';
echo '<p><b><u>This Feature Is Coming Soon!!</u></b></p>';



// Advanced Video Tab - START
