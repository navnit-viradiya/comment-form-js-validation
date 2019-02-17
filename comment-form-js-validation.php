<?php
/*
Plugin Name: Comment Form Js Validation
Plugin URI:  https://wordpress.org/plugins/comment-form-js-validation/
Description: This plugin use for wordpress comments form js validation to the comment form.
Version:     1.1
Author:      Navnit Viradiya
Author URI:  https://profiles.wordpress.org/navnitviradiya13
License: 
License URI:
*/

add_action('wp_enqueue_scripts','nv_enqueue_scripts');
function nv_enqueue_scripts() {
	if(is_single() && comments_open() ) {
		wp_enqueue_script( 'nv-jquery-validate', plugins_url( '/includes/public/js/jquery.validate.min.js', __FILE__ ),array('jquery'), false, true);
		wp_enqueue_script( 'nv-validation', plugins_url( '/includes/public/js/nv-validation.js', __FILE__ ),array('jquery'), false, true);

		$nv_comment_form_jv_option = get_option( 'nv_comment_form_jv' );
		$nv_comment_form_jv_array = array();

		if($nv_comment_form_jv_option['comment_comment_msg'] != ''){
			$nv_comment_form_jv_array['comment_comment_msg'] = __($nv_comment_form_jv_option['comment_comment_msg']); 
		} else {
			$nv_comment_form_jv_array['comment_comment_msg'] = __('Please enter your comment.');
		}

		if($nv_comment_form_jv_option['comment_name_msg'] != ''){
			$nv_comment_form_jv_array['comment_name_msg'] = __($nv_comment_form_jv_option['comment_name_msg']); 
		} else {
			$nv_comment_form_jv_array['comment_name_msg'] = __('Please enter your name.');
		}

		if($nv_comment_form_jv_option['comment_email_msg'] != ''){
			$nv_comment_form_jv_array['comment_email_msg'] = __($nv_comment_form_jv_option['comment_email_msg']); 
		} else {
			$nv_comment_form_jv_array['comment_email_msg'] = __('Please enter your email address.');
		}
		
		// Localize the script with message
		wp_localize_script( 'nv-validation', 'cfjv_obj', $nv_comment_form_jv_array );
	}
}

add_action('wp_enqueue_scripts','nv_wp_enqueue_styles');
function nv_wp_enqueue_styles(){
	if(is_single() && comments_open() ) {
		wp_enqueue_style( 'nv-validation-style',  plugins_url( '/includes/public/css/nv-validation.css', __FILE__ ));
		wp_enqueue_style( 'nv-validation-style' );
	}
}


if(is_admin()){
	require_once('includes/admin/class-comment-form-js-validation-admin.php');
}

/*function require_comment_name($fields) {

	if(!is_user_logged_in()){
	    if ($fields['comment_author_url'] == '') {
	    	wp_die('Error: please enter a url.');
	    }
	}

	return $fields;
}
add_filter('preprocess_comment', 'require_comment_name');*/
?>
