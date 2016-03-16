<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'spacious_before_post_content' ); ?>
	<div class="entry-content clearfix">
		<div class="study-plan-form-container">
			<form method="post" action="">
				<p class="login-username">
					<label for="study-plan">Study plan</label>
            		<textarea name="study-plan" rows="15"></textarea>
				</p>
				<p class="study-plan-submit">
					<input type="submit" value="Send">
				</p>
			</form>
		</div>
	</div>

	<?php spacious_entry_meta(); ?>

	<?php
	do_action( 'spacious_after_post_content' );
   ?>
</article>