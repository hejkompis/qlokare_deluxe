<?php

// !!! INFO !!!
//
// get_stylesheet_directory() <- använd för att hänvisa till child-theme-mapp
//

require_once plugin_dir_path( __FILE__ ) . 'functions/functions-custom-register.php';
require_once plugin_dir_path( __FILE__ ) . 'functions/functions-custom-post-types.php';
require_once plugin_dir_path( __FILE__ ) . 'functions/functions-custom-taxonomies.php';
require_once plugin_dir_path( __FILE__ ) . 'functions/functions-custom-roles.php';
require_once plugin_dir_path( __FILE__ ) . 'functions/functions-widgets-and-sidebars.php';
require_once plugin_dir_path( __FILE__ ) . 'functions/functions-admin-edits.php';

function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_admin_scripts() {

    wp_enqueue_script('jquery-ui-datepicker');
    wp_register_script('qlokare_custom_admin_js', get_stylesheet_directory_uri() . '/js/custom.admin.jquery.js');
    wp_enqueue_script('qlokare_custom_admin_js');
    wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

}
add_action( 'admin_enqueue_scripts', 'theme_enqueue_admin_scripts' );

function theme_enqueue_scripts() {

    wp_enqueue_script( 'jquery' );
    wp_register_script('qlokare_custom_js', get_stylesheet_directory_uri() . '/js/custom.jquery.js', 'jquery');
    wp_enqueue_script('qlokare_custom_js');

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );

// find what class a student takes
function get_user_class($user) {
	
	$assigned_terms = wp_get_object_terms( $user->ID, 'class' );
	$assigned_term_ids = array();
    foreach( $assigned_terms as $term ) {
        $assigned_term_ids[] = $term->term_id;
    }

    return $assigned_term_ids;

}

function user_has_class($page_id) {

	if(!is_user_logged_in()) return false;

	$user = wp_get_current_user();
	$user_terms = wp_get_object_terms( $user->ID, 'class' );
	$user_term_ids = array();
    foreach( $user_terms as $term ) {
        $user_term_ids[] = $term->term_id;
    }

	$page_class = wp_get_object_terms( $page_id, 'class' );
	$page_term_ids = array();
    foreach( $page_class as $term ) {
        $page_term_ids[] = $term->term_id;
    }	

    if(array_intersect($user_term_ids, $page_term_ids)) return array_intersect($user_term_ids, $page_term_ids);
    else return false;
}

// FILE UPLOAD FOR FRONT END
function upload_user_file( $file = array() ) {

    require_once( ABSPATH . 'wp-admin/includes/admin.php' );

    $file_return = wp_handle_upload( $file, array('test_form' => false ) );

    if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
        return false;
    } else {

        $filename = $file_return['file'];

        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $file_return['url']
        );

        $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );

        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
        wp_update_attachment_metadata( $attachment_id, $attachment_data );

        if( 0 < intval( $attachment_id ) ) {
            return $attachment_id;
        }
    }

    return false;
}

add_filter( 'wp_nav_menu_items', 'add_student_link', 10, 2 );
function add_student_link( $items, $args ) {
    $user = wp_get_current_user();
    if (is_user_logged_in() && $args->theme_location == 'primary' && $user->roles[0] == 'student') {
        $items .= '<li><a href="/my-page/">My page</a></li>';
    }
    return $items;
}

add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );
function add_loginout_link( $items, $args ) {
    if (is_user_logged_in() && $args->theme_location == 'primary') {
        $items .= '<li><a href="'. wp_logout_url() .'">Log out</a></li>';
    }
    elseif (!is_user_logged_in() && $args->theme_location == 'primary') {
        $items .= '<li><a href="'. site_url('wp-login.php') .'">Log in</a></li>';
    }
    return $items;
}

function pluginname_ajaxurl() {
    echo '<script type="text/javascript">';
    echo 'var ajax_url = "'.admin_url('admin-ajax.php').'";';
    echo '</script>';
}

add_action('wp_head','pluginname_ajaxurl');

function delete_task_file($file_id) {

    wp_delete_attachment($file_id);
    delete_post_meta($file_id, 'file_for_task');

}

add_action( 'wp_ajax_nopriv_delete_task_file', 'delete_task_file');
add_action( 'wp_ajax_delete_task_file', 'delete_task_file');