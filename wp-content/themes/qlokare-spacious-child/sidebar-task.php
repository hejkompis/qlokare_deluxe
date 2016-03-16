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

	<?php
		$has_file = get_post_meta(get_the_ID(), 'cpt_has_file', true);
    	$due_date = get_post_meta(get_the_ID(), 'cpt_due_date', true);
    	$due_date_timestamp = strtotime($due_date);
    	$today = mktime(0,0,0,date('m'), date('d'), date('y'));

        $query = "SELECT 
            p.id
            FROM 
            $wpdb->posts p,
            $wpdb->postmeta pm
            WHERE p.id = pm.post_id
            AND p.post_author = ".get_current_user_id()."
            AND pm.meta_key = 'file_for_task'
            AND pm.meta_value = ".get_the_ID()."
        ";

        $posts = $wpdb->get_results($query);

        if($posts) {

            echo '<h5>Posted files</h5>';

            echo '<table>';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th>Name</th>';
                        echo '<th>Date</th>';
                        if($today <= $due_date_timestamp) echo '<th>Delete</th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                    foreach($posts as $post) { 
                        $file = get_post($post->id);

                    //    echo '<pre>';
                    //    print_r($file);
                    //    echo '</pre>';

                        echo '<tr id="task_file_'.$file->ID.'">';

                            echo '<td><a href="'.$file->guid.'" target="_blank">'.$file->post_title.'</a></td>';
                            echo '<td>'.$file->post_date.'</td>';
                            if($today <= $due_date_timestamp) echo '<td><a href="?delete='.$file->ID.'" class="task_file_delete" data-file-id="'.$file->ID.'">[x]</td>';

                        echo '</tr>';

                    }

                echo '</tbody>';
            echo '</table>';

        }
    	
    	// om det fortfarande går att lämna in
    	if($has_file && $today <= $due_date_timestamp && !$files) {

    ?>

    	<form enctype="multipart/form-data" action="" method="post">
    		<h5><label for="user_file">Submit file</label></h5>
            <p>Deadline day is <?php echo $due_date; ?></p>
    		<input type="file" id="user_file" name="user_file" /><br /><br />
    		<input type="submit" value="Submit" class="spacious-button" />
    	</form>

    <?php

    	}
    	elseif($has_file && $today > $due_date_timestamp) {
    
    ?>

        <p>Deadline has passed. It is no longer possible to submit files.</p>

    <?php

    	}

	?>
		
	<?php do_action( 'spacious_after_sidebar' ); ?>

</div>