<?php

  $user = wp_get_current_user();
  $allowed_roles = array('teacher', 'administrator');
  
  if( array_intersect($allowed_roles, $user->roles ) ) {  

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
  <div class="">
  </div>

  <h3>Weekly reports</h3>
  <table class="table">
    <tr>
      <th>Dates</th>
      <th>Rating</th>
    <tr>
      <td>No weekly reports</td>
      <td></td>
    </tr>
  </table>

<?php } ?>

