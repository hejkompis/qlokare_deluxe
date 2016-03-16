<?php

	function hejkompis_customize_register($wp_customize) {
		
		$args = array(
			'title' 	=> 'Hej kompis settings',
			'priority' 	=> 10
		);

		$wp_customize->add_section('hejkompis_settings', $args);

		$args = array(
			'default' 	=> '#fff',
			'transport'	=> 'refresh'
		);

		$wp_customize->add_setting('background', $args);
		
		$args = array(
			'label' 	=> 'Background',
			'section'	=> 'hejkompis_settings',
			'setting' 	=> 'background'
		);
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control($wp_customize, 'background', $args)
		);

		$args = array(
			'default' 	=> '#000',
			'transport'	=> 'refresh'
		);

		$wp_customize->add_setting('link_color', $args);
		
		$args = array(
			'label' 	=> 'Link color',
			'section'	=> 'hejkompis_settings',
			'setting' 	=> 'link_color'
		);
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control($wp_customize, 'link_color', $args)
		);

		$args = array(
			'default' 	=> '#000',
			'transport'	=> 'refresh'
		);

		$wp_customize->add_setting('link_hover_color', $args);
		
		$args = array(
			'label' 	=> 'Link:hover color',
			'section'	=> 'hejkompis_settings',
			'setting' 	=> 'link_hover_color'
		);
		
		$wp_customize->add_control(
			new WP_Customize_Color_Control($wp_customize, 'link_hover_color', $args)
		);

		$args = array(
        	'default'       => '',
        	'capability'    => 'edit_theme_options',
        	'transport'		=> 'refresh',
        	'type'          => 'option',
	    );

		$wp_customize->add_setting('intro_text', $args);
	 
		$args = array(
	        'label'      => 'Intro text',
	        'section'    => 'hejkompis_settings',
	        'settings'   => 'intro_text',
	    );

	    $wp_customize->add_control('intro_text', $args);

	}

	add_action('customize_register', 'hejkompis_customize_register');

	function hejkompis_customize_css() {
    
        $output  = '<style type="text/css">';
        $output .= 'body { background-color:'.get_theme_mod('background').'; }';
        $output .= 'a { color:'.get_theme_mod('link_color').'; }';
        $output .= 'a:hover { color:'.get_theme_mod('link_hover_color').'; }';
        $output .= '</style>';

        echo $output;
	
	}

	add_action('wp_head', 'hejkompis_customize_css');