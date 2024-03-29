<?php

    function movies_post_type(){

        $args = array(
            'name' => 'Movies',
            'add_new' => 'Add New Movies'
        );

        // Register the custom post type
        register_post_type('movies', array(
            'labels'         => $args,
            'public'        => true,
            'has_archive'   => true,
            'show_in_menu'  => true, // Display in the admin sidebar
            'menu_icon'     => 'dashicons-book', // Icon for the admin sidebar
            'supports'      => array('title', 'editor', 'thumbnail'),
            'show_in_rest'  => true
        ));
    }
    add_action('init', 'movies_post_type');

?>