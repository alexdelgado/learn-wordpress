<?php

namespace Sample;

class Post {

	/**
	 * Contains a single instance reference to this class.
	 *
	 * @var Post|bool $instance
	 */
	public static $instance = false;

	/**
	 * Metaboxes Constructor
	 */
	public function __construct() {
		$this->_add_filters();
	}

	public function filter_the_content( $content ) {
		echo $content;
		require( get_stylesheet_directory() .'/views/posts/article.php' );
	}

	/**
	 * Singleton
	 *
	 * Returns a single instance of the current class.
	 */
	public static function singleton() {

		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Add Actions
	 *
	 * Defines all the WordPress actions and filters used by this theme.
	 */
	protected function _add_filters() {
		if ( ! is_admin() ) {
			add_filter( 'the_content', array( $this, 'filter_the_content' ) );
		}
	}
}
