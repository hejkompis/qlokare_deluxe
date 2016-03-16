<?php 
/**
 * Theme Single Post Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
?>

<?php
if( isset($_GET['delete']) ) {
	delete_task_file($_GET['delete']);
}
if( ! empty( $_FILES ) ) {	
	foreach( $_FILES as $file ) {
		if( is_array( $file ) ) {
			$attachment_id = upload_user_file( $file );
			if($attachment_id) {
				update_post_meta($attachment_id, 'file_for_task', get_the_ID());
			}
		}
	}
}
?>

<?php get_header(); ?>

	<?php do_action( 'spacious_before_body_content' ); ?>
		
	<div id="primary">
		<div id="content" class="clearfix">
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'content', 'single' ); ?>

				<?php
					do_action( 'spacious_before_comments_template' );
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();					
	      		do_action ( 'spacious_after_comments_template' );
				?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	
	<?php get_sidebar('task'); ?>
	
	<?php do_action( 'spacious_after_body_content' ); ?>

<?php get_footer(); ?>