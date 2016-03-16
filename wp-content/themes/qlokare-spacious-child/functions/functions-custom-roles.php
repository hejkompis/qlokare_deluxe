<?php

// REMOVE STANDARD ROLES

remove_role('subscriber');
remove_role('contributor');
remove_role('author');
remove_role('editor');

// CUSTOM ROLE: STUDENT

$student_permissions = array(
	 
'read' => true, // true allows this capability
'edit_posts' => true, // Allows user to edit their own posts
'edit_pages' => true, // Allows user to edit pages
'edit_others_posts' => false, // Allows user to edit others posts not just their own
'create_posts' => true, // Allows user to create new posts
'manage_categories' => false, // Allows user to manage post categories
'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
'edit_themes' => false, // false denies this capability. User can’t edit your theme
'install_plugins' => false, // User cant add new plugins
'update_plugin' => false, // User can’t update any plugins
'update_core' => false // user cant perform core updates
 
);

$custom_user_student = add_role( 'student', __( 'Student' ), $student_permissions );

// CUSTOM ROLE: TEACHER

$teacher_permissions = array(
	 
'read' => true, // true allows this capability
'edit_posts' => false, // Allows user to edit their own posts
'edit_pages' => false, // Allows user to edit pages
'edit_others_posts' => false, // Allows user to edit others posts not just their own
'create_posts' => false, // Allows user to create new posts
'manage_categories' => true, // Allows user to manage post categories
'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
'edit_themes' => false, // false denies this capability. User can’t edit your theme
'install_plugins' => false, // User cant add new plugins
'update_plugin' => false, // User can’t update any plugins
'update_core' => false // user cant perform core updates
 
);

$custom_user_teacher = add_role( 'teacher', __( 'Teacher' ), $teacher_permissions );

add_action( 'show_user_profile', 'show_user_category' );
add_action( 'edit_user_profile', 'show_user_category' );
function show_user_category( $user ) {
 
    //get the terms that the user is assigned to 
    $assigned_terms = wp_get_object_terms( $user->ID, 'class' );
    $assigned_term_ids = array();
    foreach( $assigned_terms as $term ) {
        $assigned_term_ids[] = $term->term_id;
    }

    //get all the terms we have
    $classes = get_terms( 'class', array('hide_empty'=>false) );
 
    echo "<h3>Class</h3>";

     //list the terms as checkbox, make sure the assigned terms are checked
    foreach( $classes as $class ) { ?>
        <input type="checkbox" id="class-<?php echo $cat->term_id ?>" <?php if(in_array( $class->term_id, $assigned_term_ids )) echo 'checked=checked';?> name="class[]"  value="<?php echo $class->term_id;?>"/> 
        <?php
    	echo '<label for="user-category-'.$class->term_id.'">'.$class->name.'</label>';
    	echo '<br />';
    }

}

add_action( 'personal_options_update', 'save_user_category' );
add_action( 'edit_user_profile_update', 'save_user_category' );
function save_user_category( $user_id ) {

	$user_terms = $_POST['class'];
	$terms = array_unique( array_map( 'intval', $user_terms ) );
	wp_set_object_terms( $user_id, $terms, 'class', false );

	//make sure you clear the term cache
	clean_object_term_cache($user_id, 'class');
}