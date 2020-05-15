<?php

require 'inc/metaboxes.php';
require 'inc/cmb2-metaboxes.php';
require 'inc/post.php';

require 'inc/twentytwenty-child.php';
require 'inc/twentytwenty-child-walker.php';

add_action( 'init', array( '\sample\Metaboxes', 'singleton' ) );
add_action( 'init', array( '\sample\CMB2_Metaboxes', 'singleton' ) );
add_action( 'init', array( '\sample\Post', 'singleton' ) );
add_action( 'after_setup_theme', array( '\sample\TwentyTwenty_Child', 'load_theme_textdomain' ) );
