<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

/* METABOX 1 PARA PROYECTOS */

function lmt_tasks_metabox() {
  add_meta_box( 'lmt_tasks_metabox', __( 'My tasks', 'lmt_tasks' ), 'lmt_campos_tasks', 'my_tasks', 'advanced', 'high' );
}
add_action( 'add_meta_boxes', 'lmt_tasks_metabox' );

function lmt_campos_tasks($post) {
  //si existen se recuperan los valores de los metadatos

  $today = get_post_meta( $post->ID, 'today', true );   
  $this_week = get_post_meta( $post->ID, 'this_week', true );  
  $this_month = get_post_meta( $post->ID, 'this_month', true );  
  $this_year = get_post_meta( $post->ID, 'this_year', true );

 

  wp_nonce_field( 'lmt_campos_tasks_metabox', 'lmt_campos_tasks_metabox_nonce' );
?>

  <section class="tabs-navigation">
      <div class="box">
      <nav class="tabs-links">
        <a href="#link1"><?php _e( 'Today', 'lmt_tasks' ); ?></a>
        <a href="#link2"><?php _e( 'This week', 'lmt_tasks' ); ?></a>
        <a href="#link3"><?php _e( 'This month', 'lmt_tasks' ); ?></a>
        <a href="#link4"><?php _e( 'This year', 'lmt_tasks' ); ?></a>
        <div class="indicator"></div>
      </nav>
      <div class="tabs">
        <div class="wrap">

          <div class="tab" id="link1">         
     <p>
         <p> <label class="label1" for="today"><?php _e( 'Today:', 'lmt_tasks' ); ?></label></p>
         <textarea class="textabs1" name="today" rows="10" cols="120"  type="textarea"><?php echo esc_attr( get_post_meta( $post->ID, 'today', true ) );?></textarea>
     </p>
      </div> 
  
          <div class="tab" id="link2">     <p>
         <p> <label class="label2" for="this_week"><?php _e( 'This week:', 'lmt_tasks' ); ?></label></p>
         <textarea class="textabs2" name="this_week" rows="10" cols="120"  type="textarea"><?php echo esc_attr( get_post_meta( $post->ID, 'this_week', true ) );?></textarea>
     </p>
            </div> 
      
          <div class="tab" id="link3">  
     <p>
         <p> <label class="label3" for="this_month"><?php _e( 'This month:', 'lmt_tasks' ); ?></label></p>
         <textarea class="textabs3" name="this_month" rows="10" cols="120"  type="textarea"><?php echo esc_attr( get_post_meta( $post->ID, 'this_month', true ) );?></textarea>
     </p>
            </div>  
        
          <div class="tab" id="link4">    <p>
         <p> <label class="label4" for="this_year"><?php _e( 'This year:', 'lmt_tasks' ); ?></label></p>
         <textarea class="textabs4" name="this_year" rows="10" cols="120"  type="textarea"><?php echo esc_attr( get_post_meta( $post->ID, 'this_year', true ) );?></textarea>
     </p>
         </div>
          </div>
        </div>
      </div>
  </section>
       
<?php
}

function lmt_campos_tasks_save_data($post_id) {
  // Comprobamos si se ha definido el nonce.
  if ( ! isset( $_POST['lmt_campos_tasks_metabox_nonce'] ) ) {
    return $post_id;
  }
  $nonce = $_POST['lmt_campos_tasks_metabox_nonce'];
 
  // Verificamos que el nonce es válido.
  if ( !wp_verify_nonce( $nonce, 'lmt_campos_tasks_metabox' ) ) {
    return $post_id;
  }
 
  if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
    return $post_id;
  }

  if ( $_POST['post_type'] == 'page' ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }


  $old_today = get_post_meta( $post_id, 'today', true );    
  $old_this_week = get_post_meta( $post_id, 'this_week', true );    
  $old_this_month = get_post_meta( $post_id, 'this_month', true );      
  $old_this_year = get_post_meta( $post_id, 'this_year', true );

  
  // Saneamos lo introducido por el usuario.
  
  $today = sanitize_textarea_field( $_POST['today'] );
  $this_week = sanitize_textarea_field( $_POST['this_week'] );  
  $this_month = sanitize_textarea_field( $_POST['this_month'] );
  $this_year = sanitize_textarea_field( $_POST['this_year'] );

  
  // Actualizamos el campo meta en la base de datos.
  
  update_post_meta( $post_id, 'today', $today, $old_today );  
  update_post_meta( $post_id, 'this_week', $this_week, $old_this_week );  
  update_post_meta( $post_id, 'this_month', $this_month, $old_this_month );  
  update_post_meta( $post_id, 'this_year', $this_year, $old_this_year);

}
add_action( 'save_post', 'lmt_campos_tasks_save_data' );