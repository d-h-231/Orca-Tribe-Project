<?php

/*
Plugin Name: Story Fields
Plugin URI: http://dxhdev.wordpress.com
Description: Provides a space to add more information about a story.
Author: Diane Huang
Version: 1.0
Author URI: http://dxhdev.wordpress.com/
*/


/** Special thanks to Theme Foundation for the how-to.
 * Adds a meta box to the post editing screen
 */
function story_meta_custom_meta() {
	add_meta_box( 'story_meta', __( 'Story Fields', 'story_meta-textdomain' ), 'story_meta_callback', 'post' );
}
add_action( 'add_meta_boxes', 'story_meta_custom_meta' );

/**
 * Outputs the content of the meta box
 */
function story_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'story_meta_nonce' );
	$story_meta_stored_meta = get_post_meta( $post->ID );
	?>

	<p>
        <label for="author-name" class="story_meta-row-title"><?php _e( 'Author Name', 'story_meta-textdomain' )?></label><br>
		<input type="text" name="author-name" id="author-name" value="<?php if ( isset ( $story_meta_stored_meta['author-name'] ) ) echo $story_meta_stored_meta['author-name'][0]; ?>" />


	<p>
		<label for="author-position" class="story_meta-row-title"><?php _e( 'Author Position', 'story_meta-textdomain' )?></label><br>
		<input type="text" name="author-position" id="author-position" value="<?php if ( isset ( $story_meta_stored_meta['author-position'] ) ) echo $story_meta_stored_meta['author-position'][0]; ?>" />
	</p>


	<p>
		<label for="subject-age" class="story_meta-row-title"><?php _e( 'Artist/Writer Age Range', 'story_meta-textdomain' )?></label>
        <p><em>If group, choose youngest.</em></p>
		<select name="subject-age" id="subject-age">
			<option value="select-one" <?php if ( isset ( $story_meta_stored_meta['subject-age'] ) ) selected( $story_meta_stored_meta['subject-age'][0], 'select-one' ); ?>><?php _e( '0-5', 'story_meta-textdomain' )?></option>';
			<option value="select-two" <?php if ( isset ( $story_meta_stored_meta['subject-age'] ) ) selected( $story_meta_stored_meta['subject-age'][0], 'select-two' ); ?>><?php _e( '6-10', 'story_meta-textdomain' )?></option>';
			<option value="select-three" <?php if ( isset ( $story_meta_stored_meta['subject-age'] ) ) selected( $story_meta_stored_meta['subject-age'][0], 'select-three' ); ?>><?php _e( '11-15', 'story_meta-textdomain' )?></option>';
			<option value="select-four" <?php if ( isset ( $story_meta_stored_meta['subject-age'] ) ) selected( $story_meta_stored_meta['subject-age'][0], 'select-four' ); ?>><?php _e( '16-20', 'story_meta-textdomain' )?></option>';
			<option value="select-five" <?php if ( isset ( $story_meta_stored_meta['subject-age'] ) ) selected( $story_meta_stored_meta['subject-age'][0], 'select-five' ); ?>><?php _e( '21-25', 'story_meta-textdomain' )?></option>';
			<option value="select-six" <?php if ( isset ( $story_meta_stored_meta['subject-age'] ) ) selected( $story_meta_stored_meta['subject-age'][0], 'select-six' ); ?>><?php _e( '26-30', 'story_meta-textdomain' )?></option>';
		</select>
	</p>

	<p>
		<label for="video-embed" class="story_meta-row-title"><?php _e( 'Featured Video Embed Code', 'story_meta-textdomain' )?></label>
        <p><em>Use only for original videos by Orca Tribe.</em></p>
		<textarea name="video-embed" id="video-embed"><?php if ( isset ( $story_meta_stored_meta['video-embed'] ) ) echo $story_meta_stored_meta['video-embed'][0]; ?></textarea>
	</p>
 

	<?php
}



/**
 * Saves the custom meta input
 */
function story_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'story_meta_nonce' ] ) && wp_verify_nonce( $_POST[ 'story_meta_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
 
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'author-name' ] ) ) {
		update_post_meta( $post_id, 'author-name', sanitize_text_field( $_POST[ 'author-name' ] ) );
	}
    
    // Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'author-position' ] ) ) {
		update_post_meta( $post_id, 'author-position', sanitize_text_field( $_POST[ 'author-posisition' ] ) );
	}

	// Checks for input and saves if needed
	if( isset( $_POST[ 'video-embed' ] ) ) {
		update_post_meta( $post_id, 'video-embed', $_POST[ 'video-embed' ] );
	}

}
add_action( 'save_post', 'story_meta_save' );

/**
 * Add Photographer Name and URL fields to media uploader
 */
 
function attachment_field_credit( $form_fields, $post ) {
	$form_fields['photographer-name'] = array(
		'label' => 'Photographer Name',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'photographer_name', true ),
		'helps' => 'If provided, photo credit will be displayed',
	);

	$form_fields['photographer-url'] = array(
		'label' => 'Photographer URL',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'photographer_url', true ),
		'helps' => 'Add Photographer URL',
	);

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'attachment_field_credit', 10, 2 );

/**
 * Save values of Photographer Name and URL in media uploader
 *
 */

function attachment_field_credit_save( $post, $attachment ) {
	if( isset( $attachment['photographer-name'] ) )
		update_post_meta( $post['ID'], 'photographer_name', $attachment['photographer-name'] );

	if( isset( $attachment['photographer-url'] ) )
update_post_meta( $post['ID'], 'photographer_url', esc_url( $attachment['photographer-url'] ) );

	return $post;
}

add_filter( 'attachment_fields_to_save', 'attachment_field_credit_save', 10, 2 );



/**
 * Adds the meta box stylesheet when appropriate
 */
function story_meta_admin_styles(){
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_style( 'story_meta_box_styles', plugin_dir_url( __FILE__ ) . 'meta-box-styles.css' );
	}
}
add_action( 'admin_print_styles', 'story_meta_admin_styles' );


/**
 * Loads the color picker javascript
 */
function story_meta_color_enqueue() {
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'meta-box-color-js', plugin_dir_url( __FILE__ ) . 'meta-box-color.js', array( 'wp-color-picker' ) );
	}
}
add_action( 'admin_enqueue_scripts', 'story_meta_color_enqueue' );

/**
 * Loads the image management javascript
 */
function story_meta_image_enqueue() {
	global $typenow;
	if( $typenow == 'post' ) {
		wp_enqueue_media();
 
		// Registers and enqueues the required javascript.
		wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'meta-box-image.js', array( 'jquery' ) );
		wp_localize_script( 'meta-box-image', 'meta_image',
			array(
				'title' => __( 'Choose or Upload an Image', 'story_meta-textdomain' ),
				'button' => __( 'Use this image', 'story_meta-textdomain' ),
			)
		);
		wp_enqueue_script( 'meta-box-image' );
	}
}
add_action( 'admin_enqueue_scripts', 'story_meta_image_enqueue' );
