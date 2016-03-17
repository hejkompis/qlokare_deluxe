<?php

  global $wpdb;
  $current_user = wp_get_current_user();
  $allowed_roles = array('teacher', 'administrator');
  
  if( array_intersect($allowed_roles, $current_user->roles ) ) {  

  $query = "SELECT 
    id
    FROM 
    $wpdb->posts
    WHERE post_author = ".$_GET['user_id']."
    AND post_type = 'study_plan'
  ";
  
  $study_plans = $wpdb->get_results($query);
  $study_plan_id = $study_plans ? $study_plans[0]->id : false;
  if($study_plan_id) { 
    $study_plan = get_post($study_plan_id);
    $study_plan_approved = get_post_meta($study_plan_id, 'study_plan_approved', true);
  }

  $query = "SELECT 
    id
    FROM 
    $wpdb->posts
    WHERE post_author = ".$_GET['user_id']."
    AND post_type = 'weekly_report'
    ORDER BY post_modified DESC
  ";
    
  $weekly_reports = $wpdb->get_results($query);

?> 
  
  <h3>Extra profile information</h3>
  <table class="form-table">
    <tr>
      <th><label for="socsecnr">Social Security No</label></th>
      <td>
        <input type="text" name="socsecnr" id="socsecnr" value="<?php echo esc_attr( get_the_author_meta( 'socsecnr', $user->ID ) ); ?>" class="regular-text" /><br />
        <span class="description">YYYYMMDD-XXXX</span>
      </td>
    </tr>
  </table>

  <h3>Study plan</h3>
  <div class="box">
  <?php
    if($study_plan) {
      echo $study_plan->post_content;
      echo '<br /><br />';
      echo '<label><input type="checkbox" name="study_plan_approved"';
        if($study_plan_approved) echo ' checked="checked" ';
      echo '/> Study plan approved</label>';
      echo '<input type="hidden" name="study_plan_id" value="'.$study_plan_id.'" />';
    }
    else {
      echo 'No study plan submitted.';
    }
  ?>
  </div>

  <h3>Weekly reports</h3>
  <table class="table">
  <thead>
    <tr>
      <th>Week</th>
      <th>Comments</th>
      <th>Rating</th>
    </tr>
  </thead>
  <tbody>
    <?php if($weekly_reports) { 
      foreach($weekly_reports as $weekly_report) {
        $this_report = get_post($weekly_report->id);
        $report_posted_week = date('W', strtotime($this_report->post_modified));
        $rating = $this_report->post_excerpt == 1 ? 'Good' : 'Bad';
        echo '<tr>';
          echo '<td>'.$report_posted_week.'</td>';
          echo '<td>'.$this_report->post_content.'</td>';
          echo '<td>'.$rating.'</td>';
         echo '</tr>';
      }
    } else { ?>
      <tr>
        <td></td>
        <td>No weekly reports</td>
        <td></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>

<?php } ?>