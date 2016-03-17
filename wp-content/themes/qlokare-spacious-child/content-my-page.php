<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
?>

<?php

	$user = wp_get_current_user();
  
	$query = "SELECT 
		id
		FROM 
		$wpdb->posts
		WHERE post_author = ".get_current_user_id()."
		AND post_type = 'study_plan'
	";
	
	$study_plans = $wpdb->get_results($query);
	$study_plan_id = $study_plans ? $study_plans[0]->id : false;

	if(isset($_POST['submit_study_plan'])) {

		$post_args = array(
			'post_title' 	=> 'Study Plan for '.$user->display_name,
			'post_content' 	=> $_POST['my_study_plan'],
			'post_type'		=> 'study_plan'
		);

		if($study_plans) {
			$post_args['ID'] = $study_plan_id;
		}

		$study_plan_id = wp_insert_post($post_args);
		update_post_meta($study_plan_id, 'study_plan_approved', false);

	}	

	if($study_plan_id) $study_plan = get_post($study_plan_id);
	$study_plan_content = $study_plan_id ? $study_plan->post_content : false;
	$study_plan_approved = get_post_meta($study_plan_id, 'study_plan_approved', true);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'spacious_before_post_content' ); ?>
	<div class="entry-content clearfix">
		<h2>Welcome <?php echo $user->display_name; ?></h2>
		<div class="study-plan-form-container">
			<?php if(!$study_plan_approved) { ?>
				<form method="post" action="">
					<h5><label for="my_study_plan">Study plan</label></h5>
	            	<p><textarea name="my_study_plan" rows="15"><?php echo $study_plan_content; ?></textarea></p>
	            	<p class="small"><i>
					<?php
						if($study_plan) {
							echo 'Last update at '.$study_plan->post_modified.'. Study plan is not yet approved.';
						}
					?>
					</i></p>
					<p class="submit_study_plan">
						<input type="submit" name="submit_study_plan" value="Send">
					</p>
				</form>
			<?php } else { ?>
				<h5><label>Study plan</label></h5>
	           	<p>	
	           		<?php echo $study_plan_content; ?>
	           	</p>
	           	<p class="small"><i>
				<?php
					if($study_plan) {
						echo 'Last update at '.$study_plan->post_modified.'. Study plan approved at '.$study_plan_approved.'.';
					}
				?>
				</i></p>
			<?php } ?>
				
		</div>
	</div>

	<div class="facebook-connection" style="float:left;">
		<?php do_action('facebook_login_button');?>
	</div>

	<?php spacious_entry_meta(); ?>

	<?php
	do_action( 'spacious_after_post_content' );
   ?>
</article>