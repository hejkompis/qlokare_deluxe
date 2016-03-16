<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
?>

<div id="secondary">

	<?php do_action( 'spacious_before_sidebar' ); ?>
		<!-- hämta alla tasks som hör till den här sidan -->
		<?php

			$page_id = get_the_ID();
			$user_class = user_has_class($page_id);
			if($user_class) :

				$page_classes = wp_get_object_terms( get_the_ID(), 'class' );
				foreach($page_classes as $page_class) {
					
					//print_r($page_class);
					//$page_class_id = $page_class[0]->term_id;
					wp_reset_query();
					$args = array(
						'post_type' => 'task',
						'tax_query' => array(
							array(
								'taxonomy' => 'class',
								'field' => 'slug',
								'terms' => $page_class->slug,
							),
						),
					);

						

					$loop = new WP_Query($args);
					if($loop->have_posts()) {

						while($loop->have_posts()) : $loop->the_post();

						$task_course = get_post_meta($post->ID, 'cpt_task_course', true);
						$task_classes = wp_get_object_terms( $post->ID, 'class' );
						$task_class_ids = array();
						foreach($task_classes as $task_class) {
							$task_class_ids[] = $task_class->term_id;
						}

						//echo '<h2>'.$page_class->name.'</h2>';
						if(($task_course == $page_id) && array_intersect($task_class_ids, $user_class)) {

							echo '<a href="'.get_permalink().'">'.get_the_title().' ('.$page_class->name.')</a><br />';

						}
						endwhile;
					}

				}

		    endif;

		?>
		
	<?php do_action( 'spacious_after_sidebar' ); ?>
</div>