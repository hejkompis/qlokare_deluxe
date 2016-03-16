<?php
        
    $args = array(
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'hierarchical' => 1,
    'exclude' => '',
    'include' => '',
    'meta_key' => '',
    'meta_value' => '',
    'authors' => '',
    'child_of' => 12,
    'parent' => -1,
    'exclude_tree' => '',
    'number' => '',
    'offset' => 0,
    'post_type' => 'page',
    'post_status' => 'publish'
    ); 
    $pages = get_pages($args);

    $task_page = get_post_meta(get_the_ID(), 'cpt_task_course', true) ? get_post_meta(get_the_ID(), 'cpt_task_course', true) : false;
    $has_file = get_post_meta(get_the_ID(), 'cpt_has_file', true) ? true : false;
    $due_date = get_post_meta(get_the_ID(), 'cpt_due_date', true) ? get_post_meta(get_the_ID(), 'cpt_due_date', true) : false;

?>
    <select name="cpt_task_course" id="cpt_task_course">

    <option value="0">Select course</option>

    <?php 

        foreach($pages as $page) :
    ?>

    <option value="<?php echo $page->ID; ?>"

    <?php

        if($task_page == $page->ID) :

    ?>

        selected="selected"

    <?php

        endif;

    ?>

    >

        <?php echo $page->post_title; ?>

    </option>

    <?php 
        
        endforeach; 
    ?>

</select>

<br /><br />

<label><input type="checkbox" name="cpt_has_file" <?php if($has_file) echo 'checked="checked"'; ?> /> Möjlighet att ladda upp fil</label>

<br /><br />

<label for="cpt_due_date">Sista datum för inlämning</label><br />
<input type="text" id="cpt_due_date" name="cpt_due_date" value="<?php echo $due_date; ?>"/>
