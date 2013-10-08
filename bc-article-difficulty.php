<?php
add_action('admin_menu', 'bc_article_diff_menu');

function bc_article_diff_menu() {

	//Top-level menu for Article Difficluty Settings
	//Able to change the default name to be displayed
	//Able to set the Rating in above or below the post
	add_menu_page('Article Difficulty Settings', 'Article Difficulty', 'administrator', __FILE__, 'bc_article_diff_settings');

	//call register settings function
	add_action( 'admin_init', 'bc_article_register_settings' );
}


function bc_article_register_settings() {
	//register both settings Text Field and Combo box
	register_setting( 'bc-art-settings-group', 'bc_text_field' );
	register_setting( 'bc-art-settings-group', 'bc_above_below' );
	register_setting( 'bc-art-settings-group', 'bc_star_color' );
}

function bc_article_diff_settings() {
?>
<div class="wrap">
<h2>Article Difficulty Level Options</h2>
<?php $bc_above_below_value = get_option('bc_above_below'); //Getting Combo box value whether it is Above or Below ?>

<!-- The below line will used to show the options were saved Start -->
<?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Options Saved...') ?></strong></p>
    </div>
<?php } ?>
<!-- The below line will used to show the options were End -->


<form method="post" action="options.php">
    <?php settings_fields( 'bc-art-settings-group' ); ?>
    <?php do_settings_sections( 'bc-art-settings-group' );?>
	 
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Custom Name</th>
        <td><input type="text" name="bc_text_field" value="<?php echo get_option('bc_text_field'); ?>" /><b> &nbsp;&nbsp;&nbsp;[Default : Article Difficulty Level]</b></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Location</th>
        <td><select name="bc_above_below"><option value="above" <?php echo selected('above',$bc_above_below_value); ?>>Above</option>
		<option value="below"<?php echo selected('below',$bc_above_below_value); ?>>Below</option>
		</select>
		<b>&nbsp;&nbsp;&nbsp;[Default : Below the Post]</b>
		</td>
        </tr>
		
		 <tr valign="top">
        <th scope="row">Star Color</th>
        <td><input type="text" name="bc_star_color" value="<?php echo get_option('bc_star_color'); ?>" /><b> &nbsp;&nbsp;&nbsp;[Only Color code values with out '#' eg. FFFFFF for White and not as white]</b></td>
        </tr>
		
		 <tr valign="top">
        <th scope="row">Designed by - <a href="http://buffercode.com">Buffercode</a></th>
        
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } ?>