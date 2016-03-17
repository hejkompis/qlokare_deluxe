<?php

	/*
	Plugin Name: Grades API-connection
	Plugin URI: http://www.hejkomp.is
	Description: Connect your Wordpress site with our Grades API
	Author: Per Olsson
	Version: 0.1.0
	Author URI: http://www.hejkomp.is
	*/

function add_meta_box_to_post_for_grades() {
 
    add_meta_box(
        'grade-box',
        'Grades',
        'meta_box_for_grades',
        'page',
        'normal',
        'core'
    );

}

function meta_box_for_grades($post) {

	global $wpdb;

	$query = "SELECT 
		tr.term_taxonomy_id as id,
		t.name as name
		FROM 
		$wpdb->posts page,
		$wpdb->term_relationships tr,
		$wpdb->terms t
		WHERE page.id = tr.object_id
		AND tr.term_taxonomy_id = t.term_id
		AND page.id = ".$_GET['post']."
		AND page.post_type = 'page'
	";
    
    $data = $wpdb->get_results($query);

    $classes = array();
    foreach($data as $row) {
    	$classes[$row->id] = $row->name;
    }
     
?>

	<table class="form-table">
	<?php
		foreach($classes as $class_id => $class_name) {

			$query = "SELECT 
				u.ID as id
				FROM 
				$wpdb->users u,
				$wpdb->usermeta um,
				$wpdb->term_relationships tr
				WHERE u.ID = tr.object_id
				AND u.ID = um.user_id 
				AND um.meta_key = 'wp_capabilities'
				AND um.meta_value LIKE '%student%'
				AND tr.term_taxonomy_id = ".$class_id."
			";
		    
		    $users = $wpdb->get_results($query);

			echo '<thead>';
				echo '<tr>';
					echo '<td>'.$class_name.'</td>';
					echo '<td>Grade</td>';
				echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
				foreach($users as $user_id) {
					$this_user = get_userdata($user_id->id);
					echo '<tr>';
						echo '<th><label for="user-'.$this_user->id.'">'.$this_user->display_name.'</label></th>';
            			echo '<td>';
							echo '<input type="text" name="grade['.$this_user->id.']" id="grade-" value="" class="regular-text" /><br />';
							echo '<span class="description">A-F</span>';
						echo '</td>';
					echo '</tr>';
				}
			echo '</tbody>';
		}
	?>
    </table>

<?php

}

add_action('add_meta_boxes', 'add_meta_box_to_post_for_grades');

function special_save_grades($post_id, $post, $update) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    //if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) ) {    return; }

    // If not correct slug

    if('post' != $post->post_type) {
        return;
    }

    // Save metadata

    if ( isset( $_POST['cpt_task_course'] ) ) {
        update_post_meta( 
            $post_id, 
            'cpt_task_course', 
            sanitize_text_field( $_POST['cpt_task_course'] ) 
        );
    }

}

add_action('save_post', 'special_save_grades', 10, 3);