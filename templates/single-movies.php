<?php
get_header();

    // Retrieve src from featured image
    $image_url = get_post_thumbnail_id(get_the_ID());
    $featured_image_url = wp_get_attachment_url($image_url);
    // Retrieve genre from taxonomy
    $terms = wp_get_post_terms(get_the_ID(), 'genre');
    $str = '';
    $first = true;
    foreach($terms as $term){
        if($first){
            $str .=$term->name;
            $first = false;
        }else{
            $str .= ','.$term->name;
        }
    }

?>

    <div class="content-padding">
        <div class="content-container">
            <div class="blog-post">
                <!-- Blog post content goes here -->
                <div class="post-image">
                    <img src="<?= $featured_image_url ?>" alt="Movie Poster">
                </div>
                <div class="post-details">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    <div class="post-metadata">
                        <span class="post-rating">Rating: 8.5/10</span>
                        <span class="post-genre">Genre: <?= $str ?></span>
                    </div>
                    <p class="post-description"><?php the_content(); ?></p>
                </div>
            </div>
        </div>
    </div>

<?php
wp_reset_postdata(); // Reset post data after the loop
get_footer();
?>
