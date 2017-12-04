<?php
/**
 * Gestion des boutons pour upload un modèle ODT.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $list_type_document ) ) :
	foreach ( $list_type_document as $key => $title ) :
		?>
		<div class="block">
			<div class="container">
				<h3><?php echo esc_html( $title ); ?></h3>

				<div class="button blue upload-model margin"
							data-id="<?php esc_attr( 0 ); ?>"
							data-type="<?php echo esc_attr( $key ); ?>"
							data-action="set_model"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'associate_file' ) ); ?>">
					<i class="fa fa-upload"></i>
					<span><?php esc_html_e( 'Envoyer votre modèle personnalisé', 'digirisk' ); ?></span>
				</div>

				<ul class="margin">
					<li>
						<a href="<?php echo esc_attr( $list_document_default[ $key ]['model_url'] ); ?>"><i class="dashicons-download dashicons"></i>Télécharger le modèle courant</a>
					</li>
					<li>
						<a href="#" class="open-popup-ajax"
							data-action="view_historic_model"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'view_historic_model' ) ); ?>"
							data-parent="block"
							data-target="popup"
							data-title="<?php echo esc_attr( 'Historique des modèles: ' . $title ); ?>"
							data-type="<?php echo esc_attr( $key ); ?>"><span class="dashicons dashicons-visibility"></span><?php esc_html_e( 'Historique du modèle', 'digirisk' ); ?></a>
					</li>
					<li>
						<a href="#" class="action-attribute"
							data-action="reset_default_model"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'reset_default_model' ) ); ?>"
							data-type="<?php echo esc_attr( $key ); ?>"
							data-confirm="<?php echo esc_attr( 'Êtes vous sur de vouloir réinitialiser le modèle par défaut' ); ?>"><span class="dashicons dashicons-edit"></span>Réinitialiser le modèle par défaut</a>
					</li>

					<?php echo apply_filters( 'digi_handle_model_actions_end', '', $key ); ?>
				</ul>
			</div>

			<?php \eoxia\View_Util::exec( 'digirisk', 'handle_model', 'popup' ); ?>
		</div>
		<?php
	endforeach;
endif;
?>
