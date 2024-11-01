<?php

/**
 * Simple Video Tab.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Speedyvideo
 * @subpackage Speedyvideo/includes
 * @author     Rich Agnew <richagnew@rogers.com>
 */

// Simple Video Tab - START
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

		if (!$speedy_video_customer_id || !$speedy_video_webkey)
		{
			echo '<p>Thank you for installing the Speedy Video WordPress Plugin.</p>';
			echo '<p>To get started you must first setup a Speedy Video Account. Don\'t worry, its quick and easy and you do <b>not</b> have to put in any form of payment to get started.</p>';
			echo '<p>As an added bonus, we will give you <b>50 Speedy Video Credits</b> that will allow you to start using the system for <b><u>FREE!!</u></b></p>';
			echo '<p><b><u><a href="https://www.speedyvideo.net/accounts.html" title="Speedy Video Sign-Up Page" target="_blank">Click Here To Get Started</a></u></b></p><hr>';

		} else {

		$EVPostChosen = sanitize_text_field($_POST['EVPostChosen']);
		$EVFullPostChosen = sanitize_text_field($_POST['EVFullPostChosen']);
		$EVFullpagesChosen = sanitize_text_field($_POST['EVFullpagesChosen']);
		$submitButton = sanitize_text_field($_POST['submitButton']);
		$simple_step1_nonce_field = sanitize_text_field($_POST['simple_step1_nonce_field']);
		$simple_step2_nonce_field = sanitize_text_field($_POST['simple_step2_nonce_field']);


		if ($submitButton == "Create Your Video")
		{
			// Submit the form to the factory - START

			if (! wp_verify_nonce( $simple_step2_nonce_field, 'simple_step2_action'))
			{
				echo '<br>' . 'Sorry, your nonce did not verify.';
				exit();
			}


			$VideoType = sanitize_text_field($_POST['VideoType']);

			$ArticleTitle = sanitize_text_field($_POST['ArticleTitle']);
			$ArticleTitle = preg_replace('/[^A-Za-z0-9\-.?!@]/', ' ', $ArticleTitle);

			$ArticleText = sanitize_text_field($_POST['ArticleText']);
			$ArticleText = preg_replace('/[^A-Za-z0-9\-.?!@]/', ' ', $ArticleText);

			$CustomerName = sanitize_text_field($_POST['CustomerName']);

			$CustomerEmail = sanitize_text_field($_POST['CustomerEmail']);

			$VideoVoice = sanitize_text_field($_POST['VideoVoice']);

			$VideoTheme = sanitize_text_field($_POST['VideoTheme']);

			$DomainName = esc_url($_POST['DomainName']);
			$DomainNameTemp = parse_url($DomainName);

			$DomainName = $DomainNameTemp['host'];
			if (!$DomainName)
			{
				$DomainName = $DomainNameTemp['path'];
			}

			$LogoURL = esc_url($_POST['LogoURL']);

			$VideoImage01 = esc_url($_POST['VideoImage01']);

			$VideoImage02 = esc_url($_POST['VideoImage02']);

			$VideoImage03 = esc_url($_POST['VideoImage03']);

			$VideoImage04 = esc_url($_POST['VideoImage04']);

			$VideoImage05 = esc_url($_POST['VideoImage05']);

			$VideoImage06 = esc_url($_POST['VideoImage06']);

			$VideoImage07 = esc_url($_POST['VideoImage07']);

			$VideoImage08 = esc_url($_POST['VideoImage08']);

			$VideoImage09 = esc_url($_POST['VideoImage09']);

			$WPPostID = sanitize_text_field($_POST['WPPostID']);

			$WPArtcleFullLink = esc_url($_POST['WPArtcleFullLink']);


			//Get Info From Settings
			$sql20 = "SELECT * FROM " . $wpdb->prefix . "options";
			$sql20 = $wpdb->prepare($sql20);

			$result20 = $wpdb->get_results($sql20);

			foreach($result20 as $value)
			{
				$IDconfig = $value->IDconfig;
				$option_name = $value->option_name;
				$option_value = $value->option_value;
				$$option_name = $option_value;
			}

			
			$CustomerType = "Paid";
			$StartDateTime = date("Y-m-d H:i:s");
			$Status = "Pending";
			$SubmitButton = "Submit Form";

			$url = 'https://www.speedyvideo.net/CreateVideo.php';

			$fieldsEV = array(
			'CustomerID' => $speedy_video_customer_id,
			'WebKey' => $speedy_video_webkey,
			'CustomerName' => $CustomerName,
			'CustomerEmail' => $CustomerEmail,
			'VideoType' => $VideoType,
			'WPPostID' => $WPPostID,
			'WPArtcleFullLink' => $WPArtcleFullLink,
			'LogoURL' => $LogoURL,
			'VideoImage01' => $VideoImage01,
			'VideoImage02' => $VideoImage02,
			'VideoImage03' => $VideoImage03,
			'VideoImage04' => $VideoImage04,
			'VideoImage05' => $VideoImage05,
			'VideoImage06' => $VideoImage06,
			'VideoImage07' => $VideoImage07,
			'VideoImage08' => $VideoImage08,
			'VideoImage09' => $VideoImage09,
			'VideoImage10' => $VideoImage10,
			'ArticleTitle' => $ArticleTitle,
			'ArticleText' => $ArticleText,
			'StartDateTime' => $StartDateTime,
			'FinishDateTime' => $FinishDateTime,
			'CustomerType' => $CustomerType,
			'VideoVoice' => $VideoVoice,
			'VideoTheme' => $VideoTheme,
			'DomainName' => $DomainName,
			'Status' => $Status, 
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

			if ($ResultParsed == "Failed-Credits")
			{
				//Not enough credits

				echo '<h3>You do NOT have enough credits to make this video at this time.</h3>';
				echo '<h3>Get Speedy Video Credits ' . '<a href="admin.php?page=speedy-video-button-slug&redirect=buy_credits">Here</a>' . ' </h3>';


			} elseif ($ResultParsed == "Failed-Validate") {
				//Validation Failed

				echo'<h3>Your Information Failed To Validate.</h3>';
				echo '<h3>Your Account is NOT Active or Your Credentials Are NOT Correct.</h3>';

			} elseif ($ResultParsed == "Failed-Unknown") {
				//Validation Unknown

				echo'<h3>There was an Unknown Problem. Please Try Again.</h3>';

			} else {
				//Success.

				$speedy_video_credits = $ResultParsed;
				$speedy_video_credit_update = date("Y-m-d H:i:s");

				$sql10 = "UPDATE 
					" . $wpdb->prefix . "options 
				SET option_value = '$ResultParsed' 
				WHERE option_name = 'speedy_video_credits' 
				LIMIT 1";

				$sql10 = $wpdb->prepare($sql10);

				$result10 = $wpdb->get_results($sql10);

				$sql10 = "UPDATE 
					" . $wpdb->prefix . "options 
				SET option_value = '$speedy_video_credit_update' 
				WHERE option_name = 'speedy_video_credit_update' 
				LIMIT 1";

				$sql10 = $wpdb->prepare($sql10);

				$result10 = $wpdb->get_results($sql10);

				echo '<h3>Your Information Has Been Sent to Our Video Production Factory. Please Stand By!!</h3>';
				echo '<h3>You will receive an email when the job has been completed.</h3>';

			}


			// Submit the form to the factory - FINI

		} else 
		{

			if ($EVPostChosen)
			{
				$ID = $EVPostChosen;
			}
			
			if ($EVFullPostChosen)
			{
				$ID = $EVFullPostChosen;
			}

			if ($EVFullpagesChosen)
			{
				$ID = $EVFullpagesChosen;
			}


			if ($ID)
			{

				if (! wp_verify_nonce( $simple_step1_nonce_field, 'simple_step1_action'))
				{
					echo '<br>' . 'Sorry, your nonce did not verify.';
					exit();
				}

				echo '<h2><u>Create a Simple Video (<b>25 Credits</b>)</u></h2>';

				echo '<h3>STEP 2: Create a Video From This Post</h3>';

				$EVPostInfo	= get_post($ID);

				$ArticleTitle	= $EVPostInfo->post_title;
				$ArticleTitle = trim(strip_tags($ArticleTitle));


				$ArticleTitle = filter_var($ArticleTitle, FILTER_SANITIZE_STRING);
				$ArticleTitle = preg_replace('/[^A-Za-z0-9\-.?!@]/', ' ', $ArticleTitle);
				$WPArtcleFullLink = $EVPostInfo->guid;

				$ArticleText = $EVPostInfo->post_content;
				$ArticleText = trim(strip_tags($ArticleText));
				$ArticleText = preg_replace('/[^A-Za-z0-9\-.?!@]/', ' ', $ArticleText);
				$ArticleText = filter_var($ArticleText, FILTER_SANITIZE_STRING);

				$CustomerName = get_bloginfo();
				$CustomerName = filter_var($CustomerName, FILTER_SANITIZE_STRING);

				$DomainName = get_site_url();
				$DomainName = filter_var($DomainName, FILTER_SANITIZE_STRING);
				$DomainNameTemp = parse_url($DomainName);

				$CustomerEmail = get_option('admin_email');
				$CustomerEmail = filter_var($CustomerEmail, FILTER_SANITIZE_STRING);

				$DomainName = $DomainNameTemp['host'];
				if (!$DomainName)
				{
					$DomainName = $DomainNameTemp['path'];
				}

				$WPPostID = $ID;

				//echo "[$WPPostID]";


				echo '
		<script Language="JavaScript" Type="text/javascript">
		<!--
		function SpeedyVideo_Form_Validator(theForm)
		{
			if (theForm.LogoURL.value == "")
  			{
    			alert("Please enter a image for the \"Logo \" field.");
    			theForm.LogoURL.focus();
    			return (false);
  			}

			if (theForm.VideoImage01.value == "")
  			{
    			alert("Please enter a image for the \"Image #1 \" field.");
    			theForm.VideoImage01.focus();
    			return (false);
  			}


			return confirm("By Submitting This Form You Agree To Pay 25 Credits Out Of Your Account. Do You Agree?");
		}
		//-->
		</script>
			';

	
			echo '<form action="admin.php?page=speedy-video-button-slug&tab=create_simple_video" method="post" onsubmit="return SpeedyVideo_Form_Validator(this)" language="JavaScript">';

  			echo '<input type="hidden" value="true" name="speedy_video_button" />';
  			echo '<input type="hidden" value="Simple" name="VideoType" />';
  			echo '<input type="hidden" value="' . $WPArtcleFullLink . '" name="WPArtcleFullLink" />';

			echo '<div id="EVInputForm">';

			wp_enqueue_script('jquery');
			wp_enqueue_media();

			echo '<div>';
			echo '<div><b>(*)  Article Title:</b></div>';
			echo '<div style="padding-top:5px;"><input name="ArticleTitle" type="text" value="' . $ArticleTitle . '" maxlength="75" size="100" required></div>';
			echo '</div>';

			echo '<br>';
			echo '<div>';
			echo '<div><b>(*)  Audio Text:</b></div>';
			echo '<div style="padding-top:5px;"><textarea name="ArticleText" rows="15" cols="100" required maxlength="5000">' . $ArticleText . '</textarea></div>';


			echo '<br>';
			echo '<div>';
			echo '<div><b>Synthetic Voice:</b></div>';
			echo '<div style="padding-top:5px;">';
			echo '<select name="VideoVoice" id="VideoVoice" required>';
			echo '<option value="">[Select a Voice]</option>';
			echo '<option value="Nicole">Nicole (Female Australian)</option>';
			echo '<option value="Russell">Russell (Male Australian)</option>';
			echo '<option value="Amy">Amy (Female British)</option>';
			echo '<option value="Brian">Brian (Male British)</option>';
			echo '<option value="Emma">Emma (Female British)</option>';
			echo '<option value="Aditi">Aditi (Female Indian)</option>';
			echo '<option value="Raveena">Raveena (Female Indian)</option>';
			echo '<option value="Ivy">Ivy (Female US)</option>';
			echo '<option value="Joanna">Joanna (Female US)</option>';
			echo '<option value="Joey">Joey (Male US)</option>';
			echo '<option value="Justin">Justin (Male US)</option>';
			echo '<option value="Kendra">Kendra (Female US)</option>';
			echo '<option value="Kimberly">Kimberly (Female US)</option>';
			echo '<option value="Matthew">Matthew (Male US)</option>';
			echo '<option value="Salli">Salli (Female US)</option>';
			echo '</select>';


			echo '</div>';
			echo '</div>';

			echo '<script type="text/javascript">'; 
			echo 'function setCar() {';

			echo 'var iframe = document.getElementById("SampleSourceVoicesLink");';
			echo 'iframe.src = "' . $dir . 'admin/sampleTracks/" + this.value + ".php";';


			echo 'return false;';
			echo '}';
			echo 'document.getElementById("VideoVoice").onchange = setCar;';
			echo '</script>';

			echo '<iframe id="SampleSourceVoicesLink" src="' . $dir . 'admin/sampleTracks/blank.php" height="50" width="320" style="border:1px"></iframe>';

			echo '<br>';
			echo '<div>';
			echo '<div><b>Video Template:</b></div>';
			echo '<div style="padding-top:5px;">';
			echo '<select name="VideoTheme" id="VideoTheme" required>';
			echo '<option value="">[Choose A Video Template]</option>';
			echo '<option value="Plain">Plain White (Black Title Text)</option>';
			echo '<option value="PlainBlack">Plain Black (White Title Text)</option>';
			echo '<option value="BlackBlackAbstract">Black On Black Abstract</option>';
			echo '<option value="BlackWhiteAbstract">Black With White Abstract</option>';
			echo '<option value="BlueAbstract">Blue Abstract</option>';
			echo '<option value="ComputerScreen">Computer Screen</option>';
			echo '<option value="GrayAbstract">Gray Abstract</option>';
			echo '<option value="GreenAbstract">Green Abstract</option>';
			echo '<option value="LightBlueAbstract">Light Blue Abstract</option>';
			echo '<option value="LightGrayAbstract">Light Gray Abstract</option>';
			echo '<option value="OrangeAbstract">Orange Abstract</option>';
			echo '<option value="RedAbstract">Red Abstract</option>';
			echo '<option value="WhiteAbstract">White Abstract</option>';
			echo '<option value="YellowAbstract">Yellow Abstract</option>';
			echo '</select> <span><a href="" title="View Sample" id="ViewTemplateSample" target="_blank" style="visibility: hidden;">[View Sample]</a></span>';
			echo '</div>';
			echo '</div>';


			echo '<script type="text/javascript">'; 
			echo 'function setTemp() {';
			echo 'var spanID = document.getElementById("ViewTemplateSample");';
			echo 'spanID.href = "' . $dir . 'admin/images/" + this.value + ".png";';
			echo 'spanID.style = "visibility: visible;";';

			echo 'return false;';
			echo '}';
			echo 'document.getElementById("VideoTheme").onchange = setTemp;';
			echo '</script>';


			echo '<br>';
			echo '<div>';
			echo '<div><b>(*) Your Name:</b></div>';
			echo '<div style="padding-top:5px;"><input name="CustomerName" type="text" value="' . $CustomerName . '" maxlength="200" size="50" required></div>';
			echo '</div>';

			echo '<br>';
			echo '<div>';
			echo '<div><b>(*) Your Email Address:</b></div>';
			echo '<div style="padding-top:5px;"><input name="CustomerEmail" type="email" value="' . $CustomerEmail . '" maxlength="255" size="50" required></div>';
			echo '</div>';

			echo '<br>';
			echo '<div>';
			echo '<div><b>(*) Website URL:</b></div>';
			echo '<div style="padding-top:5px;"><input name="DomainName" type="text" value="' . $DomainName . '" maxlength="75" size="50" required></div>';
			echo '</div>';


			echo '<br>';

			echo '<div style="padding-left:5px; padding-top:5px; float: left;">';
			echo '<div><img alt="Logo" src="' . $dir . 'admin/images/logo.png" name="LogoIMG" id="LogoIMG" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="LogoURL" id="LogoURL" class="regular-text" maxlength="255" size="50" required>';
			echo '<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="(*) Insert Logo">';
			echo '</div>';


			echo '<div style="padding-left:5px; padding-top:5px; float: left;">';
			echo '<div><img alt="VideoImage01" src="' . $dir . 'admin/images/videoimage01.png" name="VideoImageIMG01" id="VideoImageIMG01" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="VideoImage01" id="VideoImage01" class="regular-text" maxlength="255" size="50" required>';
			echo '<input type="button" name="upload-img1" id="upload-img1" class="button-secondary" value="(*) Insert Image #1">';
			echo '</div>';
	

			echo '<div style="padding-left:5px; padding-top:5px; float: left;">';
			echo '<div><img alt="VideoImage02" src="' . $dir . 'admin/images/videoimage02.png" name="VideoImageIMG02" id="VideoImageIMG02" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="VideoImage02" id="VideoImage02" class="regular-text" maxlength="255" size="50">';
			echo '<input type="button" name="upload-img2" id="upload-img2" class="button-secondary" value="Insert Image #2">';
			echo '</div>';


			echo '<div style="padding-left:5px; padding-top:5px; float: left;">';
			echo '<div><img alt="VideoImage03" src="' . $dir . 'admin/images/videoimage03.png" name="VideoImageIMG03" id="VideoImageIMG03" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="VideoImage03" id="VideoImage03" class="regular-text" maxlength="255" size="50">';
			echo '<input type="button" name="upload-img3" id="upload-img3" class="button-secondary" value="Insert Image #3">';
			echo '</div>';


			echo '<div style="padding-left:5px; padding-top:5px; float: left;">';
			echo '<div><img alt="VideoImage04" src="' . $dir . 'admin/images/videoimage04.png" name="VideoImageIMG04" id="VideoImageIMG04" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="VideoImage04" id="VideoImage04" class="regular-text" maxlength="255" size="50">';
			echo '<input type="button" name="upload-img4" id="upload-img4" class="button-secondary" value="Insert Image #4">';
			echo '</div>';


			echo '<div style="padding-left:5px; padding-top:5px; float: left;">';
			echo '<div><img alt="VideoImage05" src="' . $dir . 'admin/images/videoimage05.png" name="VideoImageIMG05" id="VideoImageIMG05" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="VideoImage05" id="VideoImage05" class="regular-text" maxlength="255" size="50">';
			echo '<input type="button" name="upload-img5" id="upload-img5" class="button-secondary" value="Insert Image #5">';
			echo '</div>';


			echo '<div style="padding-left:6px; padding-top:5px; float: left;">';
			echo '<div><img alt="VideoImage06" src="' . $dir . 'admin/images/videoimage06.png" name="VideoImageIMG06" id="VideoImageIMG06" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="VideoImage06" id="VideoImage06" class="regular-text" maxlength="255" size="50">';
			echo '<input type="button" name="upload-img6" id="upload-img6" class="button-secondary" value="Insert Image #6">';
			echo '</div>';


			echo '<div style="padding-left:6px; padding-top:5px; float: left;">';
			echo '<div><img alt="VideoImage07" src="' . $dir . 'admin/images/videoimage07.png" name="VideoImageIMG07" id="VideoImageIMG07" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="VideoImage07" id="VideoImage07" class="regular-text" maxlength="255" size="50">';
			echo '<input type="button" name="upload-img7" id="upload-img7" class="button-secondary" value="Insert Image #7">';
			echo '</div>';


			echo '<div style="padding-left:6px; padding-top:5px; float: left;">';
			echo '<div><img alt="VideoImage08" src="' . $dir . 'admin/images/videoimage08.png" name="VideoImageIMG08" id="VideoImageIMG08" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="VideoImage08" id="VideoImage08" class="regular-text" maxlength="255" size="50">';
			echo '<input type="button" name="upload-img8" id="upload-img8" class="button-secondary" value="Insert Image #8">';
			echo '</div>';


			echo '<div style="padding-left:6px; padding-top:5px; float: left;">';
			echo '<div><img alt="VideoImage09" src="' . $dir . 'admin/images/videoimage09.png" name="VideoImageIMG09" id="VideoImageIMG09" border="0" width="100" height="100"></div>';
			echo '<input type="hidden" name="VideoImage09" id="VideoImage09" class="regular-text" maxlength="255" size="50">';
			echo '<input type="button" name="upload-img9" id="upload-img9" class="button-secondary" value="Insert Image #9">';
			echo '</div>';

			echo '<div style="clear: both;"></div>';


			echo '
			<div>
			<script type="text/javascript">
			';

			echo "
jQuery(document).ready(function($){
      $('#upload-btn').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var LogoURL = uploaded_image.toJSON().url;
     $('#LogoURL').val(LogoURL);
     window.document.LogoIMG.src = uploaded_image.toJSON().url;

 });
});
});


jQuery(document).ready(function($){
      $('#upload-img1').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var VideoImage01 = uploaded_image.toJSON().url;
     $('#VideoImage01').val(VideoImage01);
	window.document.VideoImageIMG01.src = uploaded_image.toJSON().url;
 });
});
});


jQuery(document).ready(function($){
      $('#upload-img2').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var VideoImage02 = uploaded_image.toJSON().url;
     $('#VideoImage02').val(VideoImage02);
	window.document.VideoImageIMG02.src = uploaded_image.toJSON().url;
 });
});
});


jQuery(document).ready(function($){
      $('#upload-img3').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var VideoImage03 = uploaded_image.toJSON().url;
     $('#VideoImage03').val(VideoImage03);
	window.document.VideoImageIMG03.src = uploaded_image.toJSON().url;
 });
});
});


jQuery(document).ready(function($){
      $('#upload-img4').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var VideoImage04 = uploaded_image.toJSON().url;
     $('#VideoImage04').val(VideoImage04);
	window.document.VideoImageIMG04.src = uploaded_image.toJSON().url;
 });
});
});


jQuery(document).ready(function($){
      $('#upload-img5').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var VideoImage05 = uploaded_image.toJSON().url;
     $('#VideoImage05').val(VideoImage05);
	window.document.VideoImageIMG05.src = uploaded_image.toJSON().url;
 });
});
});


jQuery(document).ready(function($){
      $('#upload-img6').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var VideoImage06 = uploaded_image.toJSON().url;
     $('#VideoImage06').val(VideoImage06);
	window.document.VideoImageIMG06.src = uploaded_image.toJSON().url;
 });
});
});


jQuery(document).ready(function($){
      $('#upload-img7').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var VideoImage07 = uploaded_image.toJSON().url;
     $('#VideoImage07').val(VideoImage07);
	window.document.VideoImageIMG07.src = uploaded_image.toJSON().url;
 });
});
});


jQuery(document).ready(function($){
      $('#upload-img8').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var VideoImage08 = uploaded_image.toJSON().url;
     $('#VideoImage08').val(VideoImage08);
	window.document.VideoImageIMG08.src = uploaded_image.toJSON().url;
 });
});
});


jQuery(document).ready(function($){
      $('#upload-img9').click(function(e) {
             e.preventDefault();
             var image = wp.media({ 
             title: 'Upload Image',
             multiple: false
      }).open()
      .on('select', function(e){
     var uploaded_image = image.state().get('selection').first();
     console.log(uploaded_image);
     var VideoImage09 = uploaded_image.toJSON().url;
     $('#VideoImage09').val(VideoImage09);
	window.document.VideoImageIMG09.src = uploaded_image.toJSON().url;
 });
});
});

</script>
";

			echo '</div>';

			echo '</div>';

			echo '<input type="hidden" name="WPPostID" value="' . $WPPostID . '"  /> ';
			echo '<p class="submit"><input type="submit" name="submitButton" id="submitButton" class="button button-primary" value="Create Your Video"  /></p>';

			wp_nonce_field( 'simple_step2_action', 'simple_step2_nonce_field' );

  			echo '</form>';

			echo '</div>';

		} else {

	  		echo '<form action="admin.php?page=speedy-video-button-slug&tab=create_simple_video" method="post" onsubmit="return SpeedyVideo_Form_Validator(this)" language="JavaScript">';

			echo '<h2><u>Create a Simple Video (25 Credits)</u></h2>';
		
			echo '<p>A Simple Video is the quickest and easiest video in our system.';
			echo '<br>You just choose your post / page and select your logo / images to be added.</p>';
			echo '<p>The images will be spaced out evenly throughout your video and may not correspond to the text.</p>';
 

			if ($speedy_video_credits >= 25)
			{
				echo '<h3>STEP 1: Start by Choosing a Recent Post</h3>';
				$recent_posts = wp_get_recent_posts();
				echo '<select name="EVPostChosen" onchange="this.form.submit()">';
				echo '<option value="">[Choose a Recent Post]</option>';
				foreach( $recent_posts as $recent )
				{
					echo '<option value="' . $recent["ID"] . '"';
					if ($ID == $recent["ID"]) { echo " selected "; }
					echo '>' . $recent["post_title"] . '</option>';
				}
				echo '</select>';


				echo '<br><h3>OR by Choosing a Post From the Full List</h3>';
				echo '<select name="EVFullPostChosen" onchange="this.form.submit()">';
				echo '<option value="">[Choose a Post]</option>';

				global $post;
				$args = array(
  					'numberposts' => 500
				);

				$full_posts = get_posts( $args );
				foreach ( $full_posts as $post ) : setup_postdata( $post ); ?>
				<option value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
				<?php 
					endforeach; 
					wp_reset_postdata();
				echo '</select>';


				echo '<br><h3>OR by Choosing a Page From the Full List</h3>';
				echo '<select name="EVFullpagesChosen" onchange="this.form.submit()">';
				echo '<option value="">[Choose a Page]</option>';

				$argsP = array(
  					'numberposts' => 500
				);

				$full_pages = get_pages( $argsP );
				foreach ( $full_pages as $post ) : setup_postdata( $post ); ?>
				<option value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
				<?php 
					endforeach; 
					wp_reset_postdata();
				echo '</select>';
			} else {

				echo '<h3>You do NOT have enough credits to make this video at this time.</h3>';
				echo '<h3>Get Speedy Video Credits ' . '<a href="admin.php?page=speedy-video-button-slug&redirect=buy_credits">Here</a>' . ' </h3>';

			}

			wp_nonce_field( 'simple_step1_action', 'simple_step1_nonce_field' );

  			echo '</form>';

		}

	}


	//submit_button();
}


// Simple Video Tab - START
