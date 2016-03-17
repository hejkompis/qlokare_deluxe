<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ThemeGrill
 * @subpackage Spacious
 * @since Spacious 1.0
 */
?>

<?php

    $monday_at_midnight = (date('D') == 'Mon') ? strtotime('Today 00:00:00') : strtotime('Last Monday 00:00:00');
    $sunday_at_midnight = (date('D') == 'Sun') ? strtotime('Today 23:59:59') : strtotime('Next Sunday 23:59:59');

    $current_week = (date('W', $monday_at_midnight) == date('W', $sunday_at_midnight)) ? date('W', $sunday_at_midnight) : false;

    $query = "SELECT 
        id
        FROM 
        $wpdb->posts
        WHERE post_author = ".get_current_user_id()."
        AND post_type = 'weekly_report'
    ";
    
    $weekly_reports = $wpdb->get_results($query);
    $this_week_sent = false;

    foreach($weekly_reports as $weekly_report) {
        $this_report = get_post($weekly_report->id);
        $report_posted_week = date('W', strtotime($this_report->post_modified));
        if($report_posted_week == $current_week) $this_week_sent = $this_report->post_modified;
    }

    if(isset($_POST['submit_weekly_report']) && !$this_week_sent) {

        $post_args = array(
            'post_title'    => 'Weekly report ('.$current_week.') for '.$user->display_name,
            'post_content'  => $_POST['weekly_report_content'],
            'post_excerpt'  => $_POST['weekly_report_status'],
            'post_type'     => 'weekly_report'
        );

        $post_sent = wp_insert_post($post_args);
        $this_week_sent = $post_sent ? true : false;

    } 

?>

<div id="secondary">

	<?php do_action( 'spacious_before_sidebar' ); ?>

    <h5><label for="weekly_report_content">Weekly report</label></h5>

    <?php if(!$this_week_sent) { ?>

    <form method="post" action="">
        
        <p><strong>Current week: <?php echo $current_week; ?></strong></p>
        <p><textarea name="weekly_report_content"><?php echo $study_plan_content; ?></textarea></p>
        <h5><label for="weekly_report_status">Progress</label></h5>
        <p> 
            <select name="weekly_report_status">
                <option value="1">Good</option>
                <option value="2">Bad</option>
            </select>
        </p>
        <p class="submit_study_plan">
            <input type="submit" name="submit_weekly_report" value="Send">
        </p>
    </form>

    <?php } else { ?>
		
        <p>Weekly report for week <?php echo $current_week; ?> posted on<br /><?php echo $this_week_sent; ?>.</p>

    <?php } ?>

	<?php do_action( 'spacious_after_sidebar' ); ?>

</div>