<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class CKD_ExTax_Taxonomies
 */
class CKD_ExTax_Taxonomies {

	/**
	 * Hook the initialize method to the WP init action.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'initialize' ) );
	}

	/**
	 * Initialize post types & taxonomies.
	 *
	 * @since 1.0.0
	 */
	public static function initialize() {
		self::register_taxonomies();
	}

	/**
	 * Register Cooked core taxonomies
	 *
	 * @since 1.0.0
	 */
	public static function register_taxonomies() {

		if ( ! taxonomy_exists( 'recipe_cuisine' ) ) {
			$cuisine_labels = apply_filters( 'ckd_recipe_cuisine_labels', array(
				'name'                       => _x( "Cuisines", 'Taxonomy General Name', 'cooked-extra-taxonomies' ),
				'singular_name'              => _x( "Cuisine", 'Taxonomy Singular Name', 'cooked-extra-taxonomies' ),
				'menu_name'                  => __( "Cuisine", 'cooked-extra-taxonomies' ),
				'all_items'                  => __( "All Cuisines", 'cooked-extra-taxonomies' ),
				'parent_item'                => __( "Parent Cuisine", 'cooked-extra-taxonomies' ),
				'parent_item_colon'          => __( "Parent Cuisine:", 'cooked-extra-taxonomies' ),
				'new_item_name'              => __( "New Cuisine Name", 'cooked-extra-taxonomies' ),
				'add_new_item'               => __( "Add New Cuisine", 'cooked-extra-taxonomies' ),
				'edit_item'                  => __( "Edit Cuisine", 'cooked-extra-taxonomies' ),
				'update_item'                => __( "Update Cuisine", 'cooked-extra-taxonomies' ),
				'separate_items_with_commas' => __( "Separate cuisines with commas", 'cooked-extra-taxonomies' ),
				'search_items'               => __( "Search cuisines", 'cooked-extra-taxonomies' ),
				'add_or_remove_items'        => __( "Add or remove cuisines", 'cooked-extra-taxonomies' ),
				'choose_from_most_used'      => __( "Choose from the most used cuisines", 'cooked-extra-taxonomies' ),
			) );

			$cuisine_args = apply_filters( 'ckd_recipe_cuisine_taxonomy_args', array(
				'labels'       => $cuisine_labels,
				'hierarchical' => true,
				'public'       => true,
				'show_ui'      => true,
				'rewrite'      => array(
					'slug'       => 'cuisine',
					'with_front' => false,
				),
			) );

			register_taxonomy( 'recipe_cuisine', array( 'recipe', 'ingredient' ), $cuisine_args );
			register_taxonomy_for_object_type( 'recipe_cuisine', 'recipe' );
			register_taxonomy_for_object_type( 'recipe_cuisine', 'ingredient' );
		}

		if ( ! taxonomy_exists( 'recipe_method' ) ) {
			$method_labels = apply_filters( 'ckd_recipe_method_labels', array(
				'name'                       => _x( "Methods", 'Taxonomy General Name', 'cooked-extra-taxonomies' ),
				'singular_name'              => _x( "Method", 'Taxonomy Singular Name', 'cooked-extra-taxonomies' ),
				'menu_name'                  => __( "Method", 'cooked-extra-taxonomies' ),
				'all_items'                  => __( "All Methods", 'cooked-extra-taxonomies' ),
				'parent_item'                => __( "Parent Method", 'cooked-extra-taxonomies' ),
				'parent_item_colon'          => __( "Parent Method:", 'cooked-extra-taxonomies' ),
				'new_item_name'              => __( "New Method Name", 'cooked-extra-taxonomies' ),
				'add_new_item'               => __( "Add New Method", 'cooked-extra-taxonomies' ),
				'edit_item'                  => __( "Edit Method", 'cooked-extra-taxonomies' ),
				'update_item'                => __( "Update Method", 'cooked-extra-taxonomies' ),
				'separate_items_with_commas' => __( "Separate Methods with commas", 'cooked-extra-taxonomies' ),
				'search_items'               => __( "Search methods", 'cooked-extra-taxonomies' ),
				'add_or_remove_items'        => __( "Add or remove methods", 'cooked-extra-taxonomies' ),
				'choose_from_most_used'      => __( "Choose from the most used methods", 'cooked-extra-taxonomies' ),
			) );

			$method_args = apply_filters( 'ckd_recipe_method_taxonomy_args', array(
				'labels'  => $method_labels,
				'public'  => true,
				'show_ui' => true,
				'rewrite' => array(
					'slug'       => 'method',
					'with_front' => false,
				),
			) );

			register_taxonomy( 'recipe_method', array( 'recipe' ), $method_args );
			register_taxonomy_for_object_type( 'recipe_method', 'recipe' );
		}

	}

}

CKD_ExTax_Taxonomies::init();
