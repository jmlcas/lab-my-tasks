<?php
/*
* Plugin Name: Lab My tasks 
* Description: This plugin create a Custom Post Type "My tasks" with a metabox.
* Version:     1.2.3
* Author:      Labarta
* Author URI:  https://labarta.es/
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: lmt_tasks
* Domain Path: /languages
*/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require plugin_dir_path( __FILE__ ) . 'includes/lmt-metabox-1.php';

/* Enqueue admin styles */

function lmt_custom_admin_styles() {
    wp_enqueue_style('custom-styles', plugins_url('/css/styles.css', __FILE__ ));
	}
add_action('admin_enqueue_scripts', 'lmt_custom_admin_styles');

function lmt_custom_script() {
    wp_enqueue_script('custom-script', plugins_url('js/tabs.js', __FILE__), array('jquery'),'1', true );
    }
add_action('admin_enqueue_scripts', 'lmt_custom_script');

/* Languages */

load_plugin_textdomain( 'lmt_tasks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	
 function lmt_my_tasks(){
     register_post_type(
         'my_tasks',
         array(
             'labels'=>array(
                 'name'              =>__('Tasks', 'post type general name', 'lmt_tasks'),
                 'singular_name'     =>__('Task', 'post type singular name', 'lmt_tasks'),
				 'menu_name'         =>__('My Tasks', 'lmt_tasks'),
                 'add_new'           =>__('Add new', 'lmt_tasks'),
                 'add_new_item'      =>__('Add_new_task', 'lmt_tasks'),
                 'edit_item'         =>__('Edit task', 'lmt_tasks'),
                 'new_item'          =>__('New task', 'lmt_tasks'),
                 'view_item'         =>__('View task', 'lmt_tasks'),
                 'search_items'      =>__('Search tasks', 'lmt_tasks'),
                 'not_found'         =>__('Not found', 'lmt_tasks'),
                 'not_found_in_trash'=>__('Not found in trash', 'lmt_tasks'),
           ),  
			 
         'public'                => true,
         'has_archive'           => false,
         'hierarchical'          => true,
		 'show_ui'               => true,
		 'show_in_menu'          => true,
		 'menu_position'         => 15,
		 'menu_icon'             => 'dashicons-portfolio',
		 'show_in_admin_bar'     => false,
		 'show_in_nav_menus'     => true,
		 'can_export'            => true,
		 'exclude_from_search'   => false,
		 'publicly_queryable'    => true, 
		 'capability_type'       => 'page',	
		 'show_in_rest'          => false, 
         'supports'=>array('title', 'thumbnail', 'editor'),   
       ) 
	 );
 }
 add_action('init','lmt_my_tasks');
 

 function lmt_classic_editor_none() {
   echo '<style type="text/css">
            body.post-type-my_tasks #postdivrich {
            display: none;
            }
         </style>';
}

add_action('admin_head', 'lmt_classic_editor_none');




