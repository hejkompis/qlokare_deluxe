<?php

  global $wpdb;

//  $query = "SELECT 
//    p.id as ID, p.post_title as post_title, p.post_date as post_date, u.display_name as display_name
//    FROM 
//    $wpdb->posts p,
//    $wpdb->postmeta pm,
//    $wpdb->users u
//    WHERE p.id = pm.post_id
//    AND p.author = u.ID
//    AND pm.meta_key = 'file_for_task'
//    AND pm.meta_value = '".$_GET['post']."''
//  ";

  $query = "SELECT 
    p.id
    FROM 
    $wpdb->posts p,
    $wpdb->postmeta pm
    WHERE p.id = pm.post_id
    AND p.post_author = ".get_current_user_id()."
    AND pm.meta_key = 'file_for_task'
    AND pm.meta_value = ".$_GET['post']."
  ";

  $posts = $wpdb->get_results($query);

?>

<table class="table">
  <thead>
    <tr>
      <th>Student</th>
      <th>File</th>
      <th>Date</th>
    </tr>
  </thead>
  <tbody>

<?php

  if($posts) {

    foreach($posts as $post) { 
      
      $file = get_post($post->id);
      $author = get_userdata($file->post_author);

      $editlink  = '/wp-admin/user-edit.php?user_id='.(int)$author->ID;

        echo '<tr id="task_file_'.$file->ID.'">';

          echo '<td><a href="'.$editlink.'">'.$author->display_name.'</a></td>';
          echo '<td><a href="'.$file->guid.'" target="_blank">'.$file->post_title.'</a></td>';
          echo '<td>'.$file->post_date.'</td>';
    }

  }

  else {

    echo '<td></td>';
    echo '<td>No files posted</td>';
    echo '<td></td>';

  }

?>
  </tbody>
</table>