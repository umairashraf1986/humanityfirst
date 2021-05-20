<?php

add_action( 'admin_menu', 'hfusa_admin_menu_site_options' );

function hfusa_admin_menu_site_options() {
	add_options_page( 'Site Configurations', 'Site Configurations', 'manage_options', 'hf_site_options_page', 'hfusa_admin_menu_site_options_page' );
}

function hfusa_admin_menu_site_options_page(){

	$tab=isset($_GET['tab']) && !empty($_GET['tab']) ? $_GET['tab'] : 'paypal';

	/* Paypal Configurations */
	$hf_paypal_environment = get_option( 'hf_paypal_environment' );
	$hf_paypal_merchant_email = get_option( 'hf_paypal_merchant_email' );
	$hf_paypal_client_id = get_option( 'hf_paypal_client_id' );
	$hf_paypal_client_secret = get_option( 'hf_paypal_client_secret' );

	/* Stripe Configuration */
	$hf_stripe_secret = get_option( 'hf_stripe_secret' );
	$hf_stripe_publishable_key = get_option( 'hf_stripe_publishable_key' );

	/* Facebook Configurations */
	$hf_fb_app_id = get_option( 'hf_fb_app_id' );
	$hf_fb_app_secret = get_option( 'hf_fb_app_secret' );

	/* Google+ Configurations */
	$hf_gplus_client_id = get_option( 'hf_gplus_client_id' );
	$hf_gplus_client_secret = get_option( 'hf_gplus_client_secret' );
	$hf_gplus_developer_key = get_option( 'hf_gplus_developer_key' );

	/* Twitter Configurations */
	$hf_twitter_oauth_access_token = get_option( 'hf_twitter_oauth_access_token' );
	$hf_twitter_oauth_access_token_secret = get_option( 'hf_twitter_oauth_access_token_secret' );
	$hf_twitter_consumer_key = get_option( 'hf_twitter_consumer_key' );
	$hf_twitter_consumer_secret = get_option( 'hf_twitter_consumer_secret' );

	/* Youtube Configurations */
	$hf_youtube_api_key = get_option( 'hf_youtube_api_key' );


	if(isset($_POST['save_paypal_configurations'])){

		$hf_paypal_environment	=	!empty($_POST['hf_paypal_environment']) ? $_POST['hf_paypal_environment'] : '';
		$hf_paypal_merchant_email	=	!empty($_POST['hf_paypal_merchant_email']) ? $_POST['hf_paypal_merchant_email'] : '';
		$hf_paypal_client_id	=	!empty($_POST['hf_paypal_client_id']) ? $_POST['hf_paypal_client_id'] : '';
		$hf_paypal_client_secret	=	!empty($_POST['hf_paypal_client_secret']) ? $_POST['hf_paypal_client_secret'] : '';

		update_option( 'hf_paypal_environment',$hf_paypal_environment );
		update_option( 'hf_paypal_merchant_email',$hf_paypal_merchant_email );
		update_option( 'hf_paypal_client_id',$hf_paypal_client_id );
		update_option( 'hf_paypal_client_secret',$hf_paypal_client_secret );
	}

	if(isset($_POST['save_stripe_configurations'])){

		$hf_stripe_secret	=	!empty($_POST['hf_stripe_secret']) ? $_POST['hf_stripe_secret'] : '';
		$hf_stripe_publishable_key	=	!empty($_POST['hf_stripe_publishable_key']) ? $_POST['hf_stripe_publishable_key'] : '';

		update_option( 'hf_stripe_secret',$hf_stripe_secret );
		update_option( 'hf_stripe_publishable_key',$hf_stripe_publishable_key );
	}

	if(isset($_POST['save_facebook_configurations'])){

		$hf_fb_app_id	=	!empty($_POST['hf_fb_app_id']) ? $_POST['hf_fb_app_id'] : '';
		$hf_fb_app_secret	=	!empty($_POST['hf_fb_app_secret']) ? $_POST['hf_fb_app_secret'] : '';

		update_option( 'hf_fb_app_id',$hf_fb_app_id );
		update_option( 'hf_fb_app_secret',$hf_fb_app_secret );
	}

	if(isset($_POST['save_gplus_configurations'])){

		$hf_gplus_client_id	=	!empty($_POST['hf_gplus_client_id']) ? $_POST['hf_gplus_client_id'] : '';
		$hf_gplus_client_secret	=	!empty($_POST['hf_gplus_client_secret']) ? $_POST['hf_gplus_client_secret'] : '';

		$hf_gplus_developer_key	=	!empty($_POST['hf_gplus_developer_key']) ? $_POST['hf_gplus_developer_key'] : '';

		update_option( 'hf_gplus_client_id',$hf_gplus_client_id );
		update_option( 'hf_gplus_client_secret',$hf_gplus_client_secret );
		update_option( 'hf_gplus_developer_key',$hf_gplus_developer_key );
	}

	if(isset($_POST['save_twitter_configurations'])){

		$hf_twitter_oauth_access_token	=	!empty($_POST['hf_twitter_oauth_access_token']) ? $_POST['hf_twitter_oauth_access_token'] : '';
		$hf_twitter_oauth_access_token_secret	=	!empty($_POST['hf_twitter_oauth_access_token_secret']) ? $_POST['hf_twitter_oauth_access_token_secret'] : '';
		$hf_twitter_consumer_key	=	!empty($_POST['hf_twitter_consumer_key']) ? $_POST['hf_twitter_consumer_key'] : '';
		$hf_twitter_consumer_secret	=	!empty($_POST['hf_twitter_consumer_secret']) ? $_POST['hf_twitter_consumer_secret'] : '';

		update_option( 'hf_twitter_oauth_access_token',$hf_twitter_oauth_access_token );
		update_option( 'hf_twitter_oauth_access_token_secret',$hf_twitter_oauth_access_token_secret );
		update_option( 'hf_twitter_consumer_key',$hf_twitter_consumer_key );
		update_option( 'hf_twitter_consumer_secret',$hf_twitter_consumer_secret );
	}

	if(isset($_POST['save_youtube_configurations'])){

		$hf_youtube_api_key	=	!empty($_POST['hf_youtube_api_key']) ? $_POST['hf_youtube_api_key'] : '';
		update_option( 'hf_youtube_api_key',$hf_youtube_api_key );
	}
	?>
	<style>
	.site-configurations-tabs ul {
		margin: 0;
	}
	.site-configurations-tabs li {
		display: inline-block;
		margin: 0;
	}
	.site-configurations-tabs li a {
		display: block;
		font-weight: bold;
		background-color: #ddd;
		text-decoration: none;
		padding: 12px 20px;
	}
	.site-configurations-tabs li a.current-tab {
		background-color: #fff;
		cursor: default;
		pointer-events: none;
	}
	h2.hf_title_configration {
		font-size: 16px !important;
		font-weight: bold !important;
	}
</style>
<div class="wrap">
	<h2>Site Configurations</h2><br>
</div>


<div class="site-configurations-tabs">
	<ul>
		<li>
			<a href="<?php echo get_admin_url(); ?>/options-general.php?page=hf_site_options_page&tab=paypal" class="<?php

			if($tab=='paypal'){
				echo 'current-tab';
			}

			?>">PayPal</a>
		</li>
		<li>
			<a href="<?php echo get_admin_url(); ?>/options-general.php?page=hf_site_options_page&tab=stripe" class="<?php

			if($tab=='stripe'){
				echo 'current-tab';
			}

			?>">Stripe</a>
		</li>
		<li>
			<a href="<?php echo get_admin_url(); ?>/options-general.php?page=hf_site_options_page&tab=facebook" class="<?php

			if($tab=='facebook'){
				echo 'current-tab';
			}

			?>">Facebook</a>
		</li>
		<li>
			<a href="<?php echo get_admin_url(); ?>/options-general.php?page=hf_site_options_page&tab=gplus" class="<?php

			if($tab=='gplus'){
				echo 'current-tab';
			}

			?>">Google+</a>
		</li>
		<li>
			<a href="<?php echo get_admin_url(); ?>/options-general.php?page=hf_site_options_page&tab=twitter" class="<?php

			if($tab=='twitter'){
				echo 'current-tab';
			}

			?>">Twitter</a>
		</li>
		<li>
			<a href="<?php echo get_admin_url(); ?>/options-general.php?page=hf_site_options_page&tab=youtube" class="<?php

			if($tab=='youtube'){
				echo 'current-tab';
			}

			?>">Youtube</a>
		</li>
	</ul>
</div>

<div class="wrap narrow" style="background-color: #ffffff;padding: 0px 15px;">

	<?php 
	if($tab=='paypal'){
		?>
		<h2 class="hf_title_configration">PayPal Settings</h2>
		<form action="" method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row" valign="top"><label for="hf_paypal_environment">Environment</label></th>
						<td>
							<input type="radio" name="hf_paypal_environment" value="sandbox"  required <?php if($hf_paypal_environment=="sandbox"){ echo "checked"; }?>> Sandbox
							<input type="radio" name="hf_paypal_environment" value="live" style="margin-left:10px;" required <?php if($hf_paypal_environment=="live"){ echo "checked"; }?>> Production
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_paypal_merchant_email">Merchant Email</label></th>
						<td><input class="regular-text" id="hf_paypal_merchant_email" name="hf_paypal_merchant_email" required="" type="text" value="<?php echo $hf_paypal_merchant_email; ?>"></td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_paypal_client_id">Client ID</label></th>
						<td><input class="regular-text" id="hf_paypal_client_id" name="hf_paypal_client_id" required="" type="text" value="<?php echo $hf_paypal_client_id; ?>"></td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_paypal_client_secret">Client Secret</label></th>
						<td><input class="regular-text" id="hf_paypal_client_secret" name="hf_paypal_client_secret" required="" type="text" value="<?php echo $hf_paypal_client_secret; ?>"></td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input class="button-primary" name="save_paypal_configurations" type="submit" value="Save">
			</p>
		</form>
		<?php 
	}else if($tab=='stripe'){
		?>
		<h2 class="hf_title_configration">Stripe Settings</h2>
		<form action="" method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row" valign="top"><label for="hf_stripe_secret">Secret Key</label></th>
						<td><input class="regular-text" id="hf_stripe_secret" name="hf_stripe_secret" required="" type="text" value="<?php echo $hf_stripe_secret; ?>"></td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_stripe_publishable_key">Publishable Key</label></th>
						<td><input class="regular-text" id="hf_stripe_publishable_key" name="hf_stripe_publishable_key" required="" type="text" value="<?php echo $hf_stripe_publishable_key; ?>"></td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input class="button-primary" name="save_stripe_configurations" type="submit" value="Save">
			</p>
		</form>
		<?php
	}else if($tab=='facebook'){
		?>
		<h2 class="hf_title_configration">Facebook Settings</h2>
		<form action="" method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row" valign="top"><label for="hf_fb_app_id">App ID</label></th>
						<td><input class="regular-text" id="hf_fb_app_id" name="hf_fb_app_id" required="" type="text" value="<?php echo $hf_fb_app_id; ?>"></td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_fb_app_secret">App Secret</label></th>
						<td><input class="regular-text" id="hf_fb_app_secret" name="hf_fb_app_secret" required="" type="text" value="<?php echo $hf_fb_app_secret; ?>"></td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input class="button-primary" name="save_facebook_configurations" type="submit" value="Save">
			</p>
		</form>
		<?php
	}else if($tab=='gplus'){
		?>
		<h2 class="hf_title_configration">Google+ Settings</h2>
		<form action="" method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row" valign="top"><label for="hf_gplus_client_id">Client ID</label></th>
						<td><input class="regular-text" id="hf_gplus_client_id" name="hf_gplus_client_id" required="" type="text" value="<?php echo $hf_gplus_client_id; ?>"></td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_gplus_client_secret">Client Secret</label></th>
						<td><input class="regular-text" id="hf_gplus_client_secret" name="hf_gplus_client_secret" required="" type="text" value="<?php echo $hf_gplus_client_secret; ?>"></td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_gplus_developer_key">Developer Key</label></th>
						<td><input class="regular-text" id="hf_gplus_developer_key" name="hf_gplus_developer_key" required="" type="text" value="<?php echo $hf_gplus_developer_key; ?>"></td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input class="button-primary" name="save_gplus_configurations" type="submit" value="Save">
			</p>
		</form>
		<?php
	}else if($tab=='twitter'){
		?>
		<h2 class="hf_title_configration">Twitter Settings</h2>
		<form action="" method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row" valign="top"><label for="hf_twitter_oauth_access_token">Oauth Access Token</label></th>
						<td><input class="regular-text" id="hf_twitter_oauth_access_token" name="hf_twitter_oauth_access_token" required="" type="text" value="<?php echo $hf_twitter_oauth_access_token; ?>"></td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_twitter_oauth_access_token_secret">Oauth Access Token Secret</label></th>
						<td><input class="regular-text" id="hf_twitter_oauth_access_token_secret" name="hf_twitter_oauth_access_token_secret" required="" type="text" value="<?php echo $hf_twitter_oauth_access_token_secret; ?>"></td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_twitter_consumer_key">Consumer Key</label></th>
						<td><input class="regular-text" id="hf_twitter_consumer_key" name="hf_twitter_consumer_key" required="" type="text" value="<?php echo $hf_twitter_consumer_key; ?>"></td>
					</tr>
					<tr>
						<th scope="row" valign="top"><label for="hf_twitter_consumer_secret">Consumer Secret</label></th>
						<td><input class="regular-text" id="hf_twitter_consumer_secret" name="hf_twitter_consumer_secret" required="" type="text" value="<?php echo $hf_twitter_consumer_secret; ?>"></td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input class="button-primary" name="save_twitter_configurations" type="submit" value="Save">
			</p>
		</form>
		<?php
	}else if($tab=='youtube'){
		?>
		<h2 class="hf_title_configration">Youtube Settings</h2>
		<form action="" method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row" valign="top"><label for="hf_youtube_api_key">Youtube API Key</label></th>
						<td><input class="regular-text" id="hf_youtube_api_key" name="hf_youtube_api_key" required="" type="text" value="<?php echo $hf_youtube_api_key; ?>"></td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input class="button-primary" name="save_youtube_configurations" type="submit" value="Save">
			</p>
		</form>
		<?php
	} 
	?>
</div>
<?php
}

function hook_javascript() {
	?>
	<script>
		var hf_stripe_publishable_key = "<?php echo get_option( 'hf_stripe_publishable_key' );?>";
		var hf_paypal_environment = "<?php echo get_option( 'hf_paypal_environment' );?>";
		var hf_paypal_client_id = "<?php echo get_option( 'hf_paypal_client_id' );?>";
	</script>
	<?php
}
add_action('wp_head', 'hook_javascript');
?>