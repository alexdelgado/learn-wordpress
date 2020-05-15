<?php

namespace Sample;

class CMB2_Metaboxes {

	/**
	 * Contains a single instance reference to this class.
	 *
	 * @var Metaboxes|bool $instance
	 */
	public static $instance = false;

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
	 */
	public function register_meta_boxes() {
		$cmb = new_cmb2_box(
			array(
				'id'            => 'sample_metabox',
				'title'         => __( 'CMB2 Metabox', 'cmb2' ),
				'object_types'  => array( 'post' ),
				'context'       => 'normal',
				'priority'      => 'high',
				'show_names'    => true
			)
		);

		$cmb->add_field(
			array(
				'name'       => __( 'Article Title', 'cmb2' ),
				'id'         => 'cmb2_article_title',
				'type'       => 'text'
			)
		);

		$cmb->add_field(
			array(
				'name'       => __( 'Article Description', 'cmb2' ),
				'id'         => 'cmb2_article_description',
				'type'       => 'text'
			)
		);

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
		add_action( 'cmb2_admin_init', array( $this, 'register_meta_boxes' ) );
	}
}
