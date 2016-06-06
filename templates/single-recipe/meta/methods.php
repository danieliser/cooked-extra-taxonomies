<?php
/**
 * Single Recipe Meta: Methods
 *
 * @author 		DanielIser
 * @package 	CKD/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $recipe;

$label = ckd_recipe_labels( 'methods' );

$args = array(
	'before' => $label != '' ? "<strong>$label: </strong>" : '',
	'sep'    => ', ',
	'after' => '',
);

$method_list = ckd_get_method_list( $recipe->ID, $args['before'], $args['sep'], $args['after'] );

if ( is_wp_error( $method_list ) ) {
	return;
}

?>

<div <?php ckd_markup( 'recipe-methods' ); ?>>
	<?php echo $method_list; ?>
</div>