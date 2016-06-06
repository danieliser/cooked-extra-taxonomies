<?php
/**
 * Single Recipe Meta: Cuisines
 *
 * @author 		DanielIser
 * @package 	CKD/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $recipe;

$label = ckd_recipe_labels( 'cuisines' );

$args = array(
	'before' => $label != '' ? "<strong>$label: </strong>" : '',
	'sep'    => ', ',
	'after' => '',
);

$cuisine_list = ckd_get_cuisine_list( $recipe->ID, $args['before'], $args['sep'], $args['after'] );

if ( is_wp_error( $cuisine_list ) ) {
	return;
}

?>

<div <?php ckd_markup( 'recipe-cuisines' ); ?>>
	<?php echo $cuisine_list; ?>
</div>