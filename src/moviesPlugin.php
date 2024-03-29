<?php

namespace myplugin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class moviesPlugin
{

    protected static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    function __construct()
    {

        add_action('init', array($this, 'adminAssets'));
        add_action('enqueue_block_editor_assets', array($this, 'blockEditor'));
        //add_action('init', array($this, 'setup_post_type'));
        add_action('add_meta_boxes', array($this, 'custom_post_meta_box'));
        add_action('save_post', array($this, 'wporg_save_postdata')); // Fix here
        add_action( 'init', array($this, 'wporg_register_taxonomy_genre') );
        // Hook the function to the save_post action
        add_action( 'save_post', array($this, 'auto_save_genre_taxonomy'), 10, 3 );
        add_action( 'init', array($this,'myplugin_register_post_meta'));
        add_action('rest_api_init', array($this, 'custom_field'));
        add_filter('template_include', array($this, 'custom_template_override'), 99);
    }

    function custom_template_override($template){

        if (is_single() && 'movies' == get_post_type()) {
            $new_template = plugin_dir_path(dirname(__FILE__)) . 'templates/single-movies.php';
            if (file_exists($new_template)) {
                return $new_template;
            }
            return $template;
        }
        return $template;    
    }

    function custom_field(){
        register_rest_field('movies', 'GenreType', array(
            'get_callback' => function ($object) { 
                $post_id = $object['id'];
                $genre_value = get_post_meta($post_id, 'genre_key', true);
                return $genre_value;
            }
        ));
    }

    function wporg_register_taxonomy_genre() {
        $labels = array(
            'name'              => _x( 'Genres', 'taxonomy general name' ),
            'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
            'search_items'      => __( 'Search Genres' ),
            'all_items'         => __( 'All Genres' ),
            'menu_name'         => __( 'Genre' ),
        );
        $args   = array(
            'hierarchical'      => false, // make it hierarchical (like categories)
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => 'genre' ],
            'show_in_rest'      => true
        );
        register_taxonomy( 'genre', [ 'movies' ], $args );

   }

   function auto_save_genre_taxonomy( $post_id ) {

    // Check if it's an autosave or a revision
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check if the post is being saved for the first time
    if ( 'auto-draft' === get_post_status( $post_id ) ) {
        return;
    }

    // Check if the post type is 'movies'
    if ( 'movies' !== get_post_type( $post_id ) ) {
        return;
    }

    // Get the genre meta value
    $genre = get_post_meta( $post_id, 'genre_key', true );

    // If genre is not empty, set it as the post's taxonomy term
    if ( ! empty( $genre ) ) {
        // Remove existing genre terms to avoid duplicates
        wp_set_object_terms( $post_id, null, 'genre' );

        // Add the genre meta value as a term in the 'genre' taxonomy
        wp_set_object_terms( $post_id, $genre, 'genre' );
    }
}

    // Add custom meta box to post editor screen
    function custom_post_meta_box() {
        add_meta_box(
            'custom_meta_box_id',
            'Additional Movie Details',
            array($this, 'custom_meta_box_callback'),
            'movies',
            'normal',
            'high'
        );

    }

    function myplugin_register_post_meta() {
        register_post_meta( 'movies', 'genre_key', array(
            'show_in_rest' => true, // This enables the field in the REST API
            'single'       => true, // Indicates whether the meta field has one single value
            'type'         => 'string', // The data type of the meta field
            'description'  => 'Genre of the movie', // Optional description            
        ));
    }

    // Method to save post meta data
    function wporg_save_postdata($post_id) {

        $terms = wp_get_post_terms($post_id, 'genre');

        if (isset($_POST['genre_key'])) {
            // Update post meta with the 'genre' key and the value from the form field
            update_post_meta(
                $post_id,
                'genre_key',
                sanitize_text_field($_POST['genre_key']) // Sanitize the input data before saving
            );
        }
    }


    function adminAssets()
    {
        // Enqueue your JavaScript script
        wp_enqueue_script('upload-button-script', plugin_dir_url(dirname(__FILE__)) . 'src/upload-button-handler.js', array('jquery'), null, true);

        wp_enqueue_script('search-script', plugin_dir_url(dirname(__FILE__)) . '/src/searching.js', null, true);

        wp_enqueue_style('style-shortcode', plugin_dir_url(dirname(__FILE__)) . '/src/style-shortcode.css');

        wp_enqueue_style('style-for-template', plugin_dir_url(dirname(__FILE__)) . '/src/styling.css');

        wp_localize_script('search-script', 'mainUrl', array(
            'site_url' => get_site_url()
        ));

    }

    function blockEditor(){
        $posts = get_posts(array(
            'post_type' => 'movies',
            'posts_per_page' => -1
        ));
    
        $images = array();
        foreach($posts as $post){
            $imgUrl = get_the_post_thumbnail_url($post->ID);
            $images[] = $imgUrl;
            
        }
        // Localize script data outside the function
        wp_localize_script('ournewblocktype', 'value', array(
            'images' => $images
        ));
        wp_enqueue_style('style-for-block', plugin_dir_url(dirname(__FILE__)) . '/build/index.css');
        wp_enqueue_script('ournewblocktype', plugin_dir_url(dirname(__FILE__)) . '/build/index.js', array('wp-blocks', 'wp-element', 'wp-editor'));
        register_block_type('my-plugin/view-block', array(
            'editor_script' => 'ournewblocktype',
            'render_callback' => array($this, 'callbackFunc')
        ));

    }

    function callbackFunc($attributes){

        if (!is_admin()) {
            wp_enqueue_script('frontend', plugin_dir_url(dirname(__FILE__)) . 'build/viewscript.js',array('wp-blocks', 'wp-element', 'wp-editor'), null, true);
            //wp_enqueue_style('frontendStyles', plugin_dir_url(__FILE__) . 'build/view.css');
        }

        ob_start(); ?>
        <div class="attempt-one"><pre style="display: none;"><?php echo wp_json_encode($attributes) ?></pre></div>
        <?php return ob_get_clean();
    }
    

}

$moviesplugin = new moviesPlugin();
