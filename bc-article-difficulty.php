<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

//add_action( 'admin_init', 'bc_article_js',1 );
add_action('admin_menu', 'bc_article_diff_menu');

//function bc_article_js() {
//wp_enqueue_script( 'captcha-script',plugins_url('js\jscolor.js',__FILE__) );
//}

function bc_article_diffic_style(){
    wp_enqueue_style( 'bc-article-diff-css',  plugin_dir_url( __FILE__ ).'/css/bc-article-difficulty.css');
    wp_enqueue_style( 'bc-article-icons',  plugin_dir_url( __FILE__ ).'/css/font-awesome.min.css'); 
    
    wp_enqueue_script( 'captcha-script',plugins_url('js\jscolor.js',__FILE__) );
}
add_action( 'wp_enqueue_scripts', 'bc_article_diffic_style' );
add_action( 'admin_init', 'bc_article_diffic_style');

function bc_article_diff_menu() {

	//Top-level menu for Article Difficluty Settings
	//Able to change the default name to be displayed
	//Able to set the Rating in above or below the post
	
	add_options_page( 'Article Difficulty Settings', 'Article Difficulty', 'manage_options', __FILE__, 'bc_article_diff_settings' );

	//call register settings function
	add_action( 'admin_init', 'bc_article_register_settings' );
}


function bc_article_register_settings() {
	//register both settings Text Field and Combo box
	register_setting( 'bc-art-settings-group', 'bc_text_field' );
	register_setting( 'bc-art-settings-group', 'bc_above_below' );
	register_setting( 'bc-art-settings-group', 'bc_star_color' );
	register_setting( 'bc-art-settings-group', 'bc_star_size' );
	register_setting( 'bc-art-settings-group', 'bc_star_locationh' );
	register_setting( 'bc-art-settings-group', 'bc_star_locationp' );
        register_setting( 'bc-art-settings-group', 'bc_star' );
	
	
}

function bc_article_diff_settings() {
?>
<div class="wrap">
<h2>Article Difficulty Level Options</h2>
<?php $bc_above_below_value = get_option('bc_above_below'); //Getting Combo box value whether it is Above or Below 
$bc_star_size_value = get_option('bc_star_size');
?>

<form method="post" action="options.php">
    <?php settings_fields( 'bc-art-settings-group' ); ?>
    <?php do_settings_sections( 'bc-art-settings-group' );?>
	 
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Custom Name</th>
        <td><input type="text" name="bc_text_field" value="<?php echo get_option('bc_text_field'); ?>" /></td>
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
        <th scope="row">Star</th>
        <td><input type="text" name="bc_star"  value="<?php echo get_option('bc_star'); ?>" /><i>[Default: fa-star]</i><br> Note: Please check <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">icon list</a> and get the name of the icon and paste it in the textbox (eg for <i class="fa fa-star"></i> - fa-star)</td>
        </tr>
		
		 <tr valign="top">
        <th scope="row">Star Color</th>
        <td><input type="text" class="color {required:false,pickerClosable:true}"  name="bc_star_color"  value="<?php echo get_option('bc_star_color'); ?>" /></td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Star Display Location</th>
        <td>
		
		<input type='checkbox' name='bc_star_locationh' value='1' <?php if ( 1 == get_option('bc_star_locationh') ) echo 'checked="checked"'; ?> /> Display in Home<br><br>
		<input type='checkbox' name='bc_star_locationp' value='1' <?php if ( 1 == get_option('bc_star_locationp') ) echo 'checked="checked"'; ?> /> Display in Post

		
		</td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Size of the Rating</th>
		<td>
		<input type="radio" name="bc_star_size" value="H5"<?php checked( 'H5',$bc_star_size_value ); ?>>
		<img src="<?php echo plugins_url('images/h5.PNG' , __FILE__ ); ?>" />
		</td>
        </tr>
		
		<tr valign="top">
		<td></td>
		<td>
		<input type="radio" name="bc_star_size" value="H4"<?php checked( 'H4',$bc_star_size_value ); ?>><img src="<?php echo plugins_url('images/h4.PNG' , __FILE__ ); ?>" />
		</td>
        </tr>
		
		<tr valign="top">
		<td></td>
		<td>
		<input type="radio" name="bc_star_size" value="H3"<?php checked( 'H3',$bc_star_size_value ); ?>><img src="<?php echo plugins_url('images/h3.PNG' , __FILE__ ); ?>" />
		</td>
        </tr>
		
		<tr valign="top">
		<td></td>
		<td>
		<input type="radio" name="bc_star_size" value="H2"<?php checked( 'H2',$bc_star_size_value ); ?>><img src="<?php echo plugins_url('images/h2.PNG' , __FILE__ ); ?>" />
		</td>
        </tr>
		
		<tr valign="top">
		<td></td>
		<td>
		<input type="radio" name="bc_star_size" value="H1"<?php checked( 'H1',$bc_star_size_value ); ?>><img src="<?php echo plugins_url('images/h1.PNG' , __FILE__ ); ?>" /><br>
		</td>
        </tr>		
		
		 <tr valign="top">
        <th scope="row">Designed by - <a href="http://buffercode.com">Buffercode</a></th>
        </tr>
    </table>
        <?php submit_button();  ?>

</form>
</div>
<?php } ?>