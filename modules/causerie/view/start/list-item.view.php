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

<tr class="causerie-row" data-id="<?php echo esc_attr( $causerie->id ); ?>">
	<td data-title="Ref." class="padding">
		<span>
			<strong><?php echo esc_html( $causerie->unique_identifier ); ?></strong>
			<?php
			if ( ! empty( $causerie->second_identifier ) ) :
				?>
				<strong><?php echo esc_html( $causerie->second_identifier ); ?></strong>
				<?php
			endif;
			?>
		</span>
	</td>
	<td data-title="Photo" class="padding">
		<?php do_shortcode( '[wpeo_upload id="' . $causerie->id . '" model_name="/digi/' . $causerie->get_class() . '" mode="view" single="false" field_name="image" ]' ); ?>
	</td>
	<td data-title="Catégorie" class="padding">
		<?php
		if ( isset( $causerie->risk_category ) ) :
			do_shortcode( '[digi-dropdown-categories-risk id="' . $causerie->id . '" type="causerie" display="view" category_risk_id="' . $causerie->risk_category->id . '"]' );
		else :
			?>C<?php
		endif;
		?>
	</td>
	<td data-title="Titre et description" class="padding wpeo-grid grid-1">
		<span><?php echo esc_html( $causerie->title ); ?></span>
		<span><?php echo esc_html( $causerie->content ); ?></span>
	</td>
	<td>
		<div class="action grid-layout w1">
			<?php if ( Causerie_Class::g()->get_type() === $causerie->type ) : ?>
				<a class="button light w50 edit" href="<?php echo esc_attr( admin_url( 'admin-post.php?action=start_causerie&id=' . $causerie->id ) ); ?>"><i class="icon fa fa-play"></i></a>
			<?php else : ?>
				<a class="button light w50 edit tooltip hover" aria-label="<?php echo esc_attr_e( 'Reprendre la causerie', 'digirisk' ); ?>" href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie&id=' . $causerie->id ) ); ?>"><i class="icon fa fa-play"></i></a>
			<?php endif; ?>
		</div>
	</td>
</tr>
