<?php

namespace Sample;

class Metaboxes {

	/**
	 * Contains a single instance reference to this class.
	 *
	 * @var Metaboxes|bool $instance
	 */
	public static $instance = false;

	/**
	 * Contains the article metabox fields.
	 *
	 * @var array $article_meta
	 */
	private $article_meta = array(
		'article-title',
		'article-description',
	);

	/**
	 * Metaboxes Constructor
	 */
	public function __construct() {
		$this->_add_actions();
	}

	/**
	 * Register Meta Boxes
	 *
	 * Defines all the meta boxes used by this plugin.
	 *
	 * @param WP_Post $post The object for the current post/page.
	 */
	public function register_meta_boxes( $post = null ) {
		add_meta_box( 'sample_meta_box', 'WordPress Core Metabox', array( $this, 'generate_sample_meta_box' ), 'post', 'normal', 'default' );
	}

	/**
	 * Generate Sample Meta Box
	 *
	 * Generates and displays the "Sample Details" meta box.
	 */
	public function generate_sample_meta_box() {
		global $post;

		// get post meta values if they've already been set
		$post_meta = $this->_get_post_meta( $post->ID, $this->article_meta );

		$title = ( ! empty( $post_meta[ 'article-title' ] ) ? $post_meta[ 'article-title' ]->meta_value : '' );
		$description = ( ! empty( $post_meta[ 'article-description' ] ) ? $post_meta[ 'article-description' ]->meta_value : '' );

		wp_nonce_field( 'sample_meta_box', 'sample_meta_box_nonce' );

		require( SAMPLE_PLUGIN_PATH .'views/meta-boxes/sample.php' );
	}

	/**
	 * Save Post Meta
	 *
	 * Verifies that the given post is being saved, the request is valid, and
	 * the user has the necesary permissions before handing off to the
	 * post-type-specific save method.
	 *
	 * @param int $post_id
	 */
	public function save_post_meta( $post_id = null ) {
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		 // if this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// check that our nonce is set and it is valid.
		if ( ! isset( $_POST[ 'sample_meta_box_nonce' ] ) || ! wp_verify_nonce( $_POST[ 'sample_meta_box_nonce' ], 'sample_meta_box' ) ) {
			return;
		}

		// check the user's permissions.
		if ( ! current_user_can( 'edit_page', $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$this->_save_article_meta_box( $post_id );
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
	protected function _add_actions() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_post_meta' ) );
	}

	/**
	 * Get Post Meta
	 *
	 * Utility function used to consolidate the quering of multiple meta values for the given post.
	 *
	 * @param int $post_id
	 * @param array $fields
	 */
	protected function _get_post_meta( $post_id = null, $fields = array() ) {
		global $wpdb;

		$query = "SELECT meta_key, meta_value FROM {$wpdb->postmeta} WHERE post_id = {$post_id}";

		if ( ! empty( $fields ) ) {
			$query .= " AND meta_key IN ('". implode("','", $fields) ."')";
		}

		return $wpdb->get_results( $query, OBJECT_K );
	}

	/**
	 * Save article Meta Box
	 *
	 * Handles the sanitizing and saving of the article meta box fields.
	 *
	 * @param int $post_id
	 */
	protected function _save_article_meta_box( $post_id = null ) {
		foreach( $this->article_meta as $field ) {
			$name = str_replace( '-', '_', $field );

			if ( isset( $_POST[ $name ] ) ) {
				$meta_value = sanitize_text_field( $_POST[ $name ] );
				update_post_meta( $post_id, "{$field}", $meta_value );
			}
		}
	}
}
