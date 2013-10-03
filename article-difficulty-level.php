<?php
/*
Plugin Name: Article Difficulty Level
Plugin URI: http://buffercode.com/
Description: Through this plugin, user can able to select the articles difficulty level in admin dash board post area for each post.
Version: 1.0
Author: BufferCode
Author URI: http://buffercode.com/
License: GPLv2
*/


/**
 * Post mode will be displayed in attachment, post, page area to select the difficulty of the post level
 1 - Normal
 2 - Average
 3 - Above Average
 4 - Difficult
 5 - Most Difficulty
 */
function buffercode_post_mode() {
# placing our meta box in three locations namely attachment, post and page.
    $buffercode_location = array( 'attachment', 'post', 'page');

    foreach ( $buffercode_location as $buffercode_locations ) {
/* defining meta box by filling aruguments
1. buffercode_post_mode_id => will be id for add_meta_box
2. Post Strength Mode => will be the Title for the meta box and it will be displayed in the admin dash board
3. buffercode_inner_post_mode => function to go with our busines logics.
*/
        add_meta_box(
            'buffercode_post_mode_id',
            __( 'Post Strength Mode', 'buffercode_box' ),
            'buffercode_inner_post_mode',
            $buffercode_locations
        );
    }
}
#registering our meta boxes in admin dash board.
add_action( 'add_meta_boxes', 'buffercode_post_mode' );


function buffercode_inner_post_mode( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'buffercode_inner_post_mode', 'buffercode_inner_post_mode_nonce' );

  /*
   Get the value previous value from the database to display in the admin dashboard
   */
  $value = get_post_meta( $post->ID, 'buffercode_meta_value_key', true );

  #label to show the field Select the Difficult of this Post
  echo '<label for="buffercode_post_field">';
       _e( "Select the Difficulty of this Post", 'buffercode_box' );
  echo '</label> '; ?>
  <!-- Combo box to select from 1 to 5  -->
  <select name="buffercode_post_field">
  <option value="1" <?php selected('1', $value); ?> >1</option>
  <option value="2" <?php selected('2', $value); ?> >2</option>
  <option value="3" <?php selected('3', $value); ?> >3</option>
  <option value="4" <?php selected('4', $value); ?> >4</option>
  <option value="5" <?php selected('5', $value); ?> >5</option>
  </select>
  <?php
  }

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function buffercode_save_meta_box( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['buffercode_inner_post_mode_nonce'] ) )
    return $post_id;

  $nonce = $_POST['buffercode_inner_post_mode_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'buffercode_inner_post_mode' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;

  // Check the user's permissions.
  if ( 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }

  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
  $mydata = sanitize_text_field( $_POST['buffercode_post_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, 'buffercode_meta_value_key', $mydata );
}
add_action( 'save_post', 'buffercode_save_meta_box' );

/** 
Function to display the information after the orginal content in webpage
*/
function buffercode_meta_content($content) {
global $post;
        $original = $content; //Orignial Content
		$meta_value=get_post_meta($post->ID, 'buffercode_meta_value_key',true); //Get the selected value from the admin dashboard
		$content .= $original;
		switch($meta_value) //checking for the value selected
		{
		case 1: //if value 1 selected the one star will be displayed
			$content .= "<br>Post Difficulty Level - <h2 style=\"display:inline;\">&#9734;</h2>";
			break;
		case 2: //if value 2 selected the Two star will be displayed
			$content .= "<br>Post Difficulty Level - <h2 style=\"display:inline;\">&#9734; &#9734;</h2>";
			break;
		case 3: //if value 3 selected the Three star will be displayed
			$content .= "<br>Post Difficulty Level - <h2 style=\"display:inline-block;\">&#9734; &#9734; &#9734;</h2>";
			break;
		case 4: //if value 4 selected the four star will be displayed
			$content .= "<br>Post Difficulty Level - <h2 style=\"display:inline-block;\">&#9734; &#9734; &#9734; &#9734;</h2>";
			break;
		case 5: //if value 5 selected the five star will be displayed
			$content .= "<br>Post Difficulty Level - <h2 style=\"display:inline-block;\">&#9734; &#9734; &#9734;&#9734; &#9734;</h2>";
			break;

		default:
		echo "wrong value";
				}
	
	return $content; //returning the orginal content and new content
  
}
#filter to add the above function after the content
add_filter( 'the_content', 'buffercode_meta_content' );
?>