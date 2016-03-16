<?php

	####
	## TASKS
	####

	function add_custom_post_type_task() {

		$labels = array(
			'name'                  => 'Tasks',
			'singular_name'         => 'Task',
			'menu_name'             => 'Tasks',
			'edit_item'             => 'Edit Task',
			'view_item'             => 'View Task',
			'all_items'             => 'All Tasks',
			'search_items'          => 'Search Tasks',
			'parent_item_colon'     => 'Parent Tasks:',
			'not_found'             => 'No tasks found.',
			'not_found_in_trash'    => 'No tasks found in Trash.',
			'featured_image'        => 'Task Cover Image',
			'set_featured_image'    => 'Set task image',
			'remove_featured_image' => 'Remove task image',
			'use_featured_image'    => 'Use as task image',
			'archives'              => 'Task archives',
			'insert_into_item'      => 'Insert into task',
			'uploaded_to_this_item' => 'Uploaded to this task',
			'filter_items_list'     => 'Filter task list',
			'items_list_navigation' => 'Tasks list navigation',
			'items_list'			=> 'Tasks list'
		);
 
	    $args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'task' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'comments	')
	    );

		register_post_type('task', $args);

	}

	add_action('init', 'add_custom_post_type_task');

	function add_meta_box_to_cpt_task() {
 
        add_meta_box(
            'task-options',
            'Connect to course',
            'meta_box_for_cpt_task',
            'task',
            'normal',
            'core'
        );
 
    }

	function meta_box_for_cpt_task($post) {
        require_once get_stylesheet_directory().'/partials/cpt-tasks-meta-box.php';
    }

    add_action('add_meta_boxes', 'add_meta_box_to_cpt_task');

    function add_meta_box_to_cpt_task_with_files() {
 
        add_meta_box(
            'task-files',
            'Posted files',
            'meta_box_for_cpt_task_with_files',
            'task',
            'normal',
            'core'
        );
 
    }

	function meta_box_for_cpt_task_with_files($post) {
        require_once get_stylesheet_directory().'/partials/cpt-tasks-meta-box-with-files.php';
    }

    add_action('add_meta_boxes', 'add_meta_box_to_cpt_task_with_files');

    function special_save_cpt_task($post_id, $post, $update) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times

		//if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) ) { 	return; }

		// If not correct slug

		if('task' != $post->post_type) {
			return;
		}

		// Save metadata

		if ( isset( $_POST['cpt_task_course'] ) ) {
         	update_post_meta( 
         		$post_id, 
         		'cpt_task_course', 
         		sanitize_text_field( $_POST['cpt_task_course'] ) 
         	);
     	}
     	if ( isset( $_POST['cpt_has_file'] ) ) {
         	update_post_meta( 
         		$post_id, 
         		'cpt_has_file', 
         		sanitize_text_field( $_POST['cpt_has_file'] ) 
         	);
     	}
     	else {
     		delete_post_meta(
     			$post_id, 
         		'cpt_has_file'
     		);
     	}
     	if ( isset( $_POST['cpt_due_date'] ) && $_POST['cpt_due_date'] != '' ) {
         	update_post_meta( 
         		$post_id, 
         		'cpt_due_date', 
         		sanitize_text_field( $_POST['cpt_due_date'] ) 
         	);
     	}

	}

	add_action('save_post', 'special_save_cpt_task', 10, 3);

	####
	## TASK FILES
	####

	function add_custom_post_type_task_file() {

		$labels = array(
			'name'                  => 'task_file',
			'singular_name'         => 'task_file',
		);
 
	    $args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => false,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'task_file' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'country', 'description')
	    );

		register_post_type('task_file', $args);

	}

	add_action('init', 'add_custom_post_type_task_file');

	####
	## STUDY PLAN
	####

	function add_custom_post_type_study_plan() {

		$labels = array(
			'name'                  => 'study_plan',
			'singular_name'         => 'study_plan',
		);
 
	    $args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => false,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'study_plan' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'country', 'description')
	    );

		register_post_type('study_plan', $args);

	}

	add_action('init', 'add_custom_post_type_study_plan');

	####
	## WEEKLY REPORTS
	####

	function add_custom_post_type_weekly_report() {

		$labels = array(
			'name'                  => 'weekly_report',
			'singular_name'         => 'weekly_report',
		);
 
	    $args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => false,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'weekly_report' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'country', 'description')
	    );

		register_post_type('weekly_report', $args);

	}

	add_action('init', 'add_custom_post_type_weekly_report');