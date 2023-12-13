<?php


 // Block direct access to file
 defined( 'ABSPATH' ) or die( 'Not Authorized!' );


// Contains functions create_scholarship_post_type() and create_scholarship_taxonomy()
function create_scholarship_post_type() {
    // Check if the post type already exists
    if (!post_type_exists('scholarships')) {

        $labels = array(
            'name'               => _x( 'Scholarship Applications', 'post type general name' ),
            'singular_name'      => _x( 'Scholarship Application', 'post type singular name' ),
            'add_new'            => _x( 'Add New', 'book' ),
            'add_new_item'       => __( 'Add New Application' ),
            'edit_item'          => __( 'Edit Application' ),
            'new_item'           => __( 'New Application' ),
            'all_items'          => __( 'All Applications' ),
            'view_item'          => __( 'View Application' ),
            'search_items'       => __( 'Search Applications' ),
            'not_found'          => __( 'No application found' ),
            'not_found_in_trash' => __( 'No application found in the Trash' ), 
            'parent_item_colon'  => ’,
            'menu_name'          => 'Scholarship Applications'
          );

        // Set up the arguments for the post type
        $args = array(
            'labels'        => $labels,
            'description'   => 'Holds scholarship entries and voting counts.'
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail')
            // ... You can add more arguments as needed
        );

        // Register the post type
        register_post_type('scholarships', $args);
    }
}

// Hook into the 'init' action to register our custom post type when WordPress initializes
add_action('init', 'create_scholarship_post_type');



function create_scholarship_taxonomy() {
    // Check if the post type exists before creating the taxonomy
    if (post_type_exists('scholarships')) {

        // Set up the labels for the taxonomy
        $labels = array(
            'name'              => 'Scholarship Years',
            'singular_name'     => 'Scholarship Year',
            'search_items'      => 'Search Scholarship Years',
            'all_items'         => 'All Scholarship Years',
            'parent_item'       => 'Parent Scholarship Year',
            'parent_item_colon' => 'Parent Scholarship Year:',
            'edit_item'         => 'Edit Scholarship Year',
            'update_item'       => 'Update Scholarship Year',
            'add_new_item'      => 'Add New Scholarship Year',
            'new_item_name'     => 'New Scholarship Year Name',
            'menu_name'         => 'Scholarship Year',
        );

        // Set up the arguments for the taxonomy
        $args = array(
            'hierarchical'      => true, // set to false if you want a non-hierarchical taxonomy (like tags)
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'scholarship-year'),
        );

        // Register the taxonomy
        register_taxonomy('scholarship_year', array('scholarships'), $args);
    }
}

// Hook into the 'init' action to register our taxonomy
add_action('init', 'create_scholarship_taxonomy');

