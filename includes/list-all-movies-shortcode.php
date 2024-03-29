<?php

add_shortcode('list-all-movies', 'all_movie_shortcode');

function all_movie_shortcode (){

    // Retrieve post meta data
    //$src = get_post_meta(get_the_ID(), 'img_source', true);
    $image_url = get_post_thumbnail_id();
    $featured_image_url = wp_get_attachment_url($image_url);


    //$genre = get_post_meta(get_the_ID(), 'genre_key', true);
    $genre = get_the_terms(get_the_ID(), 'genre');
    ob_start();
        ?>
        <div class="archive-content">
      <!-- Your archive content goes here -->
      <?php 
      $moviesQuery = new WP_Query (array(
        'post_type' => 'movies'
      ));

      while($moviesQuery->have_posts()){
        $moviesQuery->the_post()
        ?>
        <div class="movie-card">
            <img src="<?= wp_get_attachment_url(get_post_thumbnail_id()) ?>" alt="<?php the_title_attribute(); ?>">
            <div class="movie-title"><a href="<?= get_permalink() ?>"><?php the_title() ?></a></div>
        </div>
      <?php
      }
      ?>
      <!-- Add more movie cards here as needed -->
    </div>
    <?php
    return ob_get_clean(); // Return the buffered content
}

