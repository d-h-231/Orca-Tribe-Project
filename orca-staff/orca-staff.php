<?php
/*
Plugin Name: Orca Staff Page
Plugin URI: 
Version: 0.3
Description: Adds Staff Page.
Author: Michael Hall
*/
function wporg_custom_post_type()
{
    register_post_type('wporg_orca_staff',
                       [
                           'labels'      => [
                               'name'          => __('Staff'),
                               'singular_name' => __('Staff'),
                               'menu_name' => __('Staff'),
                               'all_items' => __('Staff List'),
                               'view_item' => __('View Staff Member'),
                               'add_new_item' => __('Add New Staff Member'),
                               'add_new' => __('Add New'),
                               'edit_item' => __('Edit Staff Info'),
                               'update_item' => __('Update Staff Info'),
                               
                           ],
                           'label' => __('staff'),
                           'description' => __('Orca Tribe Staff Members'),
                           'supports'     => ['title', 'editor', 'thumbnail', 'revisions', 'custom-fields'],
                           'public'      => true,
                           'has_archive' => true,
                           'rewrite'     => ['slug' => 'staff'],
                           
                       ]
    );
}
add_action('init', 'wporg_custom_post_type');

?>
