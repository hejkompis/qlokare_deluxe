<?php

	function hk_widget_area_one() {

		$args = array(
			'name' 	=> 'Dynamic Sidebar',
			'id' 	=> 'dynamic_sidebar'
		);

		register_sidebar($args);

	}

	add_action('widgets_init', 'hk_widget_area_one');

	function hk_footer_sidebar() {

		$args = array(
			'name' 	=> 'Footer Sidebar',
			'id' 	=> 'footer_sidebar'
		);

		register_sidebar($args);

	}

	add_action('widgets_init', 'hk_footer_sidebar');

	function hk_search_sidebar() {

		$args = array(
			'name' 	=> 'Search Sidebar',
			'id' 	=> 'search_sidebar'
		);

		register_sidebar($args);

	}

	add_action('widgets_init', 'hk_search_sidebar');