<?php

function student_login_redirect( $redirect_to, $request, $user  ) {
    return ( is_array( $user->roles ) && in_array( 'student', $user->roles ) ) ? site_url() : admin_url();
}
add_filter( 'login_redirect', 'student_login_redirect', 10, 3 );

add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
    add_menu_page( 'Students', 'Students', 'manage_options', 'students', 'myplugin_admin_page', 'dashicons-tickets', 6  );
}

function myplugin_admin_page(){
    require_once get_stylesheet_directory().'/partials/admin-students-meta-box.php';
}

// PERSONNUMMER shown only when updating a user
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );
function my_show_extra_profile_fields( $user ) { 
    require_once get_stylesheet_directory().'/partials/admin-user-edit-meta-box.php';
}
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
function my_save_extra_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    /* Copy and paste this line for additional fields. Make sure to change 'personnummer' to the field ID. */
    update_usermeta( $user_id, 'socsecnr', $_POST['socsecnr'] );
}

// remove ability to post, just use pages
function remove_posts_menu() {
    remove_menu_page('edit.php');
}
add_action('admin_init', 'remove_posts_menu');

// hide admin bar
add_filter('show_admin_bar', '__return_false');

// Hide unwanted user settings
// removes the `profile.php` admin color scheme options
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
add_filter('additional_capabilities_display', '__return_false');

if ( ! function_exists( 'cor_remove_personal_options' ) ) {
  /**
   * Removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options.
   */
  function cor_remove_personal_options( $subject ) {
    $subject = preg_replace( '#<h2>'.__("Personal Options").'</h2>.+?/table>#s', '', $subject, 1 );

    return $subject;
  }

  function cor_profile_subject_start() {
    ob_start( 'cor_remove_personal_options' );
  }

  function cor_profile_subject_end() {
    ob_end_flush();
  }
}
add_action( 'admin_head', 'cor_profile_subject_start' );
add_action( 'admin_footer', 'cor_profile_subject_end' );