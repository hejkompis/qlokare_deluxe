<?php

	// DEMO CUSTOM TAXONOMY

	function custom_year_taxonomy() {

		$args = array(
			'label' 		=> 'Year',
			'rewrite'		=> array('slug' => 'year'),
			'hierarchical' 	=> true
		);

		register_taxonomy('year_portfolio', 'portfolio', $args);
		register_taxonomy('year_places', 'place', $args);

	}

	add_action('init', 'custom_year_taxonomy');

	// ADD TAXONOMY TO USERS AND PAGES

	function register_class_taxonomy(){

		$labels = array(
			'name' => 'Classes',
			'singular_name' => 'Class',
			'search_items' => 'Search Classes',
			'all_items' => 'All Classes',
			'parent_item' => 'Parent Class',
			'parent_item_colon' => 'Parent Class',
			'edit_item' => 'Edit Class',
			'update_item' => 'Update Class',
			'add_new_item' => 'Add New Class',
			'new_item_name' => 'New Class Name',
			'menu_name' => 'Classes'
		);

		$args = array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'class')
		);

		register_taxonomy( 'class' , 'user' , $args );
	
	}
	
	add_action( 'init', 'register_class_taxonomy' );

	function register_taxonomy_to_pages() {
		register_taxonomy_for_object_type('class', 'page');
		add_post_type_support('page', 'class');
	}

	add_action('admin_init', 'register_taxonomy_to_pages');

	function register_taxonomy_to_tasks() {
		register_taxonomy_for_object_type('class', 'task');
		add_post_type_support('task', 'class');
	}

	add_action('admin_init', 'register_taxonomy_to_tasks');

	function add_class_category_menu() {
	    add_submenu_page( 'users.php' , 'Classes', 'Classes' , 'add_users',  'edit-tags.php?taxonomy=class' );
	}

	add_action(  'admin_menu', 'add_class_category_menu' );