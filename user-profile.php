<?php

/* ------------------------------------------------------------------------ *
 * Create user profile field for categories
 * ------------------------------------------------------------------------ */

/*
 * Show custom fields on profile page
 */

add_action( 'show_user_profile', 'default_category_user_profile_fields' );
add_action( 'edit_user_profile', 'default_category_user_profile_fields' );

function default_category_user_profile_fields($user) {
  $name = trim(get_user_meta($user->ID, 'first_name', true)." ".get_user_meta($user->ID, 'last_name', true));
  if(\strlen($name) == 0){
    $name = get_user_meta($user->ID, 'nickname', true);
  }
  ?>
  <h3><?php echo sprintf(__('Default Category For New Posts of %s', 'default-category'), $name);?></h3>
  
  <input type="hidden" value="<?php echo get_user_meta( $user->ID, 'default_category_id_for_user' ); ?>" name="default_category_id_for_user" />

  <table class="form-table">
    <tbody>
      <tr>
        <th scope="row"><?php _e('Categories');?></th>
        <td>
          <ul><?php wp_category_checklist(0, 0, get_user_meta( $user->ID, 'default_category_id_for_user', TRUE )); ?></ul>
        </td>
      </tr>
    </tbody>
  </table>
  
  <?php
} 


/*
 * Save custom fields
 */

add_action( 'personal_options_update', 'default_category_save_user_profile_fields' );
add_action( 'edit_user_profile_update', 'default_category_save_user_profile_fields' );

function default_category_save_user_profile_fields( $user_id ) {
  
  // Check user permissions
  if ( !current_user_can( 'edit_user', $user_id ) )
    return false;

  update_usermeta( $user_id, 'default_category_id_for_user', $_POST['post_category'] );
}

?>