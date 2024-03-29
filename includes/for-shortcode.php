<?php

add_shortcode('movie-details', 'movie_shortcode');

function movie_shortcode (){

    // Retrieve post meta data
    //$src = get_post_meta(get_the_ID(), 'img_source', true);
    $image_url = get_post_thumbnail_id(get_the_ID());
    $featured_image_url = wp_get_attachment_url($image_url);


    //$genre = get_post_meta(get_the_ID(), 'genre_key', true);
    $genre = wp_get_post_terms(get_the_ID(), 'genre');

    $first_term = reset($genre);

    ob_start();
        ?>
        <div class="content-padding">
        <div class="content-container">
            <div class="blog-post">
                <!-- Blog post content goes here -->
                <div class="post-details">
                    <div class="post-metadata">
                        <span class="post-rating">Rating: 8.5/10</span>
                        <span class="post-genre">Genre: <?= $first_term->name ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean(); // Return the buffered content
}

