<?php

namespace Sample;

class TwentyTwenty_Child {

	/**
	 * Load Plugin Text Domain
	 *
	 * Loads the theme's translated strings.
	 */
	public static function load_theme_textdomain() {
		load_theme_textdomain( 'twentytwenty-child', get_stylesheet_directory() . '/languages/' );
	}
}
