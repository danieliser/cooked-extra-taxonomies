<?php


function ckd_get_methods( $recipe_ID ) {
	$methods = get_the_terms( $recipe_ID, 'recipe_method' );

	return apply_filters( 'ckd_recipe_get_methods', $methods, $recipe_ID );
}

function ckd_get_method_list( $recipe_ID, $before = '', $sep = '', $after = '' ) {
	return get_the_term_list( $recipe_ID, 'recipe_method', $before, $sep, $after );
}

function ckd_get_cuisines( $recipe_ID ) {
	$cuisines = get_the_terms( $recipe_ID, 'recipe_cuisine' );

	return apply_filters( 'ckd_recipe_get_cuisines', $cuisines, $recipe_ID );
}

function ckd_get_cuisine_list( $recipe_ID, $before = '', $sep = '', $after = '' ) {
	return get_the_term_list( $recipe_ID, 'recipe_cuisine', $before, $sep, $after );
}


if ( ! function_exists( 'ckd_template_single_meta_cuisines' ) ) {

	/**
	 * Output the recipe meta: cuisines.
	 *
	 * @subpackage    Recipe
	 */
	function ckd_template_single_meta_cuisines() {
		ckd_get_template( 'single-recipe/meta/cuisines.php' );
	}
}

if ( ! function_exists( 'ckd_template_single_meta_methods' ) ) {

	/**
	 * Output the recipe meta: methods.
	 *
	 * @subpackage    Recipe
	 */
	function ckd_template_single_meta_methods() {
		ckd_get_template( 'single-recipe/meta/methods.php' );
	}
}

/**
 * Single Recipe Meta
 *
 * @see ckd_single_recipe_meta()
 */
add_action( 'ckd_single_recipe_meta', 'ckd_template_single_meta_cuisines', 20 );
add_action( 'ckd_single_recipe_meta', 'ckd_template_single_meta_methods', 30 );


add_filter( 'ckd_recipe_labels', 'ckd_extax_recipe_labels' );
function ckd_extax_recipe_labels( $labels = array() ) {
	return array_merge( $labels, array(
		'cuisines' => __( 'Cuisines', 'cooked-extra-taxonomies' ),
		'methods'  => __( 'Methods', 'cooked-extra-taxonomies' ),
	) );
}

add_filter( 'ckd_template_overload', 'ckd_extax_template_overload' );
function ckd_extax_template_overload( $template_overload = array() ) {

	if ( is_tax( 'recipe_cuisine' ) || is_tax( 'recipe_method' ) ) {

		$term = get_queried_object();

		$template_overload[] = 'archive-recipe.php';
		$template_overload[] = CKD()->template_path() . 'archive-recipe.php';
		$template_overload[] = 'taxonomy-' . $term->taxonomy . '.php';
		$template_overload[] = CKD()->template_path() . 'taxonomy-' . $term->taxonomy . '.php';
		$template_overload[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
		$template_overload[] = CKD()->template_path() . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';

		return $template_overload;
	}

	return $template_overload;
}

