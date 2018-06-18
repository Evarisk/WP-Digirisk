<?php
/**
 * Affichage d'une causerie dans l'onglet "Ajouter une causerie".
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
		<div class="action grid-layout w3">
			<?php if ( ! empty( $causerie->document ) && ! empty( $causerie->document->path ) ) : ?>
				<a class="button purple h50" href="<?php echo esc_attr( $causerie->document->path ); ?>">
					<i class="fa fa-download icon" aria-hidden="true"></i>
				</a>
			<?php else : ?>
				<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'ODT Corrompu', 'digirisk' ); ?>">
					<i class="fa fa-times icon" aria-hidden="true"></i>
				</span>
			<?php endif; ?>

			<!-- Editer un causerie -->
			<div 	class="button light w50 edit action-attribute"
						data-id="<?php echo esc_attr( $causerie->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_edit_causerie' ) ); ?>"
						data-loader="causerie-row"
						data-action="load_edit_causerie"><i class="icon fa fa-pencil"></i></div>

			<div 	class="button light w50 delete action-delete"
						data-id="<?php echo esc_attr( $causerie->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_causerie' ) ); ?>"
						data-message-delete="<?php echo esc_attr_e( 'Supprimer cette causerie ?', 'digirisk' ); ?>"
						data-action="delete_causerie"><i class="icon fa fa-times"></i></div>
		</div>
	</td>
</tr>
