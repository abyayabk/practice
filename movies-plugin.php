<?php

/*
* Plugin Name: Movies Plugin
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use myplugin\moviesPlugin;

if (!defined('MOVIES_PLUGIN_FILE')) {
    define('MOVIES_PLUGIN_FILE', __FILE__);
}

require_once(plugin_dir_path(__FILE__) . 'src/moviesPlugin.php');
require_once(plugin_dir_path(__FILE__) . 'includes/search-route.php');
require_once(plugin_dir_path(__FILE__) . 'includes/for-shortcode.php');
require_once(plugin_dir_path(__FILE__) . 'includes/list-all-movies-shortcode.php');



/**
 * Return the main instance of Movies Plugin.
 *
 * @since 1.0.0
 * @return moviesPlugin
 */
function MPlugin()
{
    return moviesPlugin::instance();
}

MPlugin();



