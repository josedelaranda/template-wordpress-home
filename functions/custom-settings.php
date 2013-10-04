<?php
// create custom plugin settings menu
add_action('admin_menu', 'omr_create_menu');

function omr_create_menu() {

	//create new top-level menu
	add_menu_page('Custom Settings', 'Custom Settings', 'administrator', __FILE__, 'omr_settings_page' );

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}

function register_mysettings() {
	//register our settings
	register_setting( 'omr-settings-group', 'omr_tracking_code' );
	register_setting( 'omr-settings-group', 'facebook_page' );
	register_setting( 'omr-settings-group', 'twitter_page' );
	register_setting( 'omr-settings-group', 'youtube_page' );
}

function omr_settings_page() {
?>

<style type="text/css">

.text {
	width: 30%;
}

</style>

<div class="wrap">
<h2>Custom Settings Template</h2>

<form method="post" action="options.php">

    <?php settings_fields('omr-settings-group'); ?>
    <table class="form-table">

        <tr valign="top">
			<th scope="row">Google Analytics</th>
			<td><input class="text" value="<?php echo get_option('omr_tracking_code'); ?>" name="omr_tracking_code" /></td>
        </tr>
		<tr valign="top">
			<th scope="row">Facebook Page</th>
			<td><input class="text" value="<?php echo get_option('facebook_page'); ?>" name="facebook_page" /></td>
        </tr>
		<tr valign="top">
			<th scope="row">Twitter Page</th>
			<td><input class="text" value="<?php echo get_option('twitter_page'); ?>" name="twitter_page" /></td>
        </tr>
		<tr valign="top">
			<th scope="row">Youtube Page</th>
			<td><input class="text" value="<?php echo get_option('youtube_page'); ?>" name="youtube_page" /></td>
        </tr>

    </table>

    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php } ?>