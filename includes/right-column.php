<?php

/**
 * Right Column.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Speedyvideo
 * @subpackage Speedyvideo/includes
 * @author     Rich Agnew <richagnew@rogers.com>
 */


// Right Column - START

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Update Credits - START
	require_once plugin_dir_path( __FILE__ ) . 'update-credits.php';
// Update Credits - Fini


if (!$speedy_video_credits)
{
	$speedy_video_credits = 0;
}

// Display Balance
echo '<div align="center" width="100%" style="border-style:solid; border-width:1px; border-color: #000000; padding-bottom: 10px; background-color: #FFFF00;">';
echo '<h1><b>' . $speedy_video_credits . ' Credits</b></h1>';

echo '<div align="center" style="background-color:#FFC0C0; width:95%; padding:5px;"><b><a href="admin.php?page=speedy-video-button-slug&redirect=update_credits" title="Update Credits"><font color="#000000">Update Credits</font></a></b></div>';

echo '<div style="color:red;"><b>My Current Balance</b></div>';
echo '<div style="font-size:10px;"><b>Last Updated:</b> ' . $speedy_video_credit_update . '</div>';
echo '<br><div align="center"><a href="admin.php?page=speedy-video-button-slug&redirect=buy_credits" title="Buy Speedy Video Credits"><img alt="Buy Speedy Video Credits" border="0" src="' . $dir . 'admin/images/SV-BuyButton.png"></a></div>';
echo '</div>';

// WordPress Hacked Service
echo '<br><div align="center"><a href="https://www.computer-geek.net/wordpress-hacked.htm" title="Is Your WordPress Hacked?" target="_blank"><img alt="Is Your WordPress Hacked?" border="0" src="' . $dir . 'admin/images/CG-hacked.png"></a></div>';

// WordPress Speed Up Service
echo '<br><div align="center"><a href="https://www.computer-geek.net/wordpress-speed-up.htm" title="WordPress Speed Up Service" target="_blank"><img alt="WordPress Speedup Service" border="0" src="' . $dir . 'admin/images/CG-WP-speed.png"></a></div>';


// Right Column - Fini