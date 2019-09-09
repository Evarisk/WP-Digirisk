<?php
/**
 * La liste des catégories de danger.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input class="input-hidden-danger" type="hidden" name="worktype_category_id"
	value='<?php echo ! empty( $select_category_worktype ) ? esc_attr( $select_category_worktype->data['id'] ) : '-1'; ?>' />

<div class="wpeo-dropdown dropdown-large category-worktype padding wpeo-tooltip-event"
			data-tooltip-persist="true"
			data-color="red"
			aria-label="<?php esc_html_e( 'Vous devez choisir un type de travaux', 'digirisk' ); ?>">

	<div class="dropdown-toggle wpeo-button button-transparent">
		<span class="<?php echo ! empty( $select_category_worktype ) && ! empty( $select_category_worktype ) ? 'hidden' : ''; ?>"><?php esc_html_e( 'Type de travaux', 'digirisk' ); ?></span>
		<img class="<?php echo ! empty( $select_category_worktype ) ? '' : 'hidden'; ?> tooltip hover" src="<?php echo ! empty( $select_category_worktype ) ? esc_attr( wp_get_attachment_url( $select_category_worktype->data['thumbnail_id'] ) ) : ''; ?>" aria-label="" />
		<i class="button-icon fas fa-angle-down"></i>
	</div>

	<ul class="dropdown-content wpeo-grid grid-5">
		<?php
		if ( ! empty( $worktype_categories ) ) :
			foreach ( $worktype_categories as $worktype_category ) :
				?>
				<li class="item dropdown-item wpeo-tooltip-event item-worktype" data-is-preset="" aria-label="<?php echo esc_attr( $worktype_category->data['name'] ); ?>" data-id="<?php echo esc_attr( $worktype_category->data['id'] ); ?>">
					<?php echo wp_get_attachment_image( $worktype_category->data['thumbnail_id'], 'thumbnail', false ); ?>
				</li>
				<?php
			endforeach;
		endif;
		?>
	</ul>
</div>

<style media="screen">
	.category-worktype img{
		border : solid 1px black;
	    border-radius: 4px;
	}
</style>
