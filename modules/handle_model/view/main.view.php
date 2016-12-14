<?php
/**
 * Affichages des boutons permettant d'envoyer les modèles ODT personnalisés
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! empty( $list_type_document ) ) :
	foreach ( $list_type_document as $key => $title ) :
		?>
		<div class="block">
			<div>
				<h3><?php echo esc_html( $title ); ?></h3>

				<div class="wp-digi-bton-first upload"
							data-id="<?php esc_attr( 0 ); ?>"
							data-type="<?php echo esc_attr( $key ); ?>"
							data-title="<?php echo esc_attr( $title ); ?>"
							data-object-name="<?php echo esc_attr( $key ); ?>"
							data-action="eo_set_model"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'associate_file' ) ); ?>">
					<?php do_shortcode( '[eo_upload_button action="eo_set_model" type="' . $key . '"]' ); ?>
					<span>Envoyer votre modèle personnalisé</span>
				</div>

				<a href="<?php echo esc_attr( $list_document_default[ $key ]['model_url'] ); ?>" class="wp-digi-bton-second"><i class="dashicons-download dashicons"></i>Télécharger le modèle courant</a>

				<a href="#" class="open-popup-ajax"
					data-action="view_historic_model"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'view_historic_model' ) ); ?>"
					data-parent="block"
					data-target="popup"
					data-title="<?php echo esc_attr( 'Historique des modèles: ' . $title ); ?>"
					data-type="<?php echo esc_attr( $key ); ?>"><span class="dashicons dashicons-visibility"></span>Historique des modèles personnalisés</a>

				<a href="#" class="action-attribute"
					data-action="reset_default_model"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'reset_default_model' ) ); ?>"
					data-type="<?php echo esc_attr( $key ); ?>"
					data-confirm="<?php echo esc_attr( 'Êtes vous sur de vouloir réinitialiser le modèle par défaut' ); ?>"><span class="dashicons dashicons-edit"></span>Réinitialiser le modèle par défaut</a>
			</div>

			<?php view_util::exec( 'handle_model', 'popup' ); ?>
		</div>
		<?php
	endforeach;
endif;
?>
