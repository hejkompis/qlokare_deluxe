<?php
/**
 * Template Name: Home
 *
 * The homepage
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
?>

<?php 

	global $wpdb;

	$query = "SELECT 
		tt.term_id as id,
		t.name name
    	FROM 
    	$wpdb->term_taxonomy tt,
    	$wpdb->terms t
       	WHERE t.term_id = tt.term_id
    	AND tt.taxonomy = 'class'

	";
    
	$data = $wpdb->get_results($query);

	$classes = array();
	foreach($data as $class) {
		$classes[$class->id] = $class->name;
	}

?>

<?php get_header(); ?>

	<?php do_action( 'spacious_before_body_content' ); ?>
		
	<div id="primary">
		<div id="content" class="clearfix">

			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'content' ); ?>

			<?php endwhile; ?>

			<hr />

			<div class="classes">

				<h4>Our classes</h4>

				<?php

					foreach($classes as $class_id => $class_name) {
						
						echo '<ul>';
							echo '<li><strong>'.$class_name.' ('.$class_id.')</strong></li>';

						$query = "SELECT 
							u.ID as id
					    	FROM 
					    	$wpdb->term_relationships tr,
					    	$wpdb->users u,
					    	$wpdb->usermeta um
					       	WHERE u.ID = tr.object_id
					       	AND u.ID = um.user_id
					       	AND um.meta_key = 'wp_capabilities'
					    	AND um.meta_value LIKE '%student%'
					    	AND tr.term_taxonomy_id = ".$class_id."
					    	GROUP BY u.ID
						";
					    
						$user_ids = $wpdb->get_results($query);

						foreach($user_ids as $user_id) {

							$user = get_userdata($user_id->id);

							echo '<li>'.$user->display_name.'</li>';

						}

						echo '</ul><br />';

					}

				?>

			</div>

		</div><!-- #content -->
	</div><!-- #primary -->
		
	<?php do_action( 'spacious_after_body_content' ); ?>

<?php get_footer(); ?>