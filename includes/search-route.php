<?php

add_action('rest_api_init', 'registerSearch');

function registerSearch(){
    // register_rest_route('custom-movies/v1', 'search', array(
    //     'methods' => WP_REST_SERVER::READABLE, // Basically GET method but just to make sure it works in all web hosts
    //     'callback' => 'moviesResults',
    // ));
}

function moviesResults ($data) {
    $genre = isset($data['genre']) ? sanitize_text_field($data['genre']) : '';

    $args = array(
        'post_type' => 'movies',
        's' => sanitize_text_field($data['term']),
        'meta_query' => array(
                'key' => 'genre_key', // Meta key for genre
                'value' => $genre, // Genre value to search for
                'compare' => 'LIKE', // Match the genre value
        )
        );
    $movies = new WP_Query($args);

    $arr = array();

    while($movies->have_posts()){
        $movies->the_post();
        array_push($arr, array(
            'Title' => get_the_title(),
            'Link' => get_the_permalink(),
            'Genre' => get_post_meta(get_the_ID(), 'genre_key', true)
        ));
    }

    return $arr;
}