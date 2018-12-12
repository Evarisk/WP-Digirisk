<?php
/**
 * Affichage d'une causerie
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="causerie-row" data-id="<?php echo esc_attr( $causerie->data['id'] ); ?>">
	<td data-title="Ref." class="padding">
		<span>
			<strong><?php echo esc_html( $causerie->data['unique_identifier'] ); ?></strong>
			<?php
			if ( ! empty( $causerie->data['second_identifier'] ) ) :
				?>
				<strong><?php echo esc_html( $causerie->data['second_identifier'] ); ?></strong>
				<?php
			endif;
			?>
		</span>
	</td>
	<td data-title="Photo" class="padding">
		<?php echo do_shortcode( '[wpeo_upload id="' . $causerie->data['id'] . '" model_name="' . $causerie->get_class() . '" mode="view" single="false" field_name="image" ]' ); ?>
	</td>
	<td data-title="Catégorie" class="padding">
		<?php
		if ( isset( $causerie->data['risk_category'] ) ) :
			do_shortcode( '[digi_dropdown_categories_risk id="' . $causerie->data['id'] . '" type="causerie" display="view" category_risk_id="' . $causerie->data['risk_category']->data['id'] . '"]' );
		else :
			?>C<?php
		endif;
		?>
	</td>
	<td data-title="Titre et description" class="padding causerie-description">
		<span class="row-title"><?php echo esc_html( $causerie->data['title'] ); ?></span>
		<span class="row-subtitle"><?php echo esc_html( $causerie->data['content'] ); ?></span>
	</td>
	<td>
		<div class="action wpeo-gridlayout grid-1 grid-gap-0">
			<?php if ( Causerie_Class::g()->get_type() === $causerie->data['type'] ) : ?>
				<a class="wpeo-button light button-square-50 edit" href="<?php echo esc_attr( admin_url( 'admin-post.php?action=start_causerie&id=' . $causerie->data['id'] ) ); ?>"><i class="icon fa fa-play"></i></a>
			<?php else : ?>
				<a class="wpeo-button light button-square-50 edit wpeo-tooltip-event hover" aria-label="<?php echo esc_attr_e( 'Reprendre la causerie', 'digirisk' ); ?>" href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie&id=' . $causerie->data['id'] ) ); ?>"><i class="icon fa fa-play"></i></a>
			<?php endif; ?>
		</div>
	</td>
</tr>
