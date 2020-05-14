<?php

/**
 * Plugin Name: Sample Plugin
 * Plugin URI:
 * Description: A sample WordPress plugin
 * Author: Alex Delgado
 * Author URI: https://alexdelgado.github.io/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package sample
 */

require 'inc/metaboxes.php';

define( 'SAMPLE_PLUGIN_URI', plugins_url( null, __FILE__ ) );
define( 'SAMPLE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'init', array( 'Metaboxes', 'singleton' ) );
