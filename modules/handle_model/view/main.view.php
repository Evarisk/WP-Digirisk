<?php
/**
 * Affichages par bloc de chaque type de document ODT.
 *
 * Pour chaque bloc nous retrouvons 4 boutons:
 * -Envoyer un modèle personnalisé
 * -Télécharger le modèle actif
 * -Historique des modèles
 * -Réintialiser le modèle par défaut.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.3.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

if ( ! empty( $list_type_document ) ) :
	foreach ( $list_type_document as $key => $data ) :
		?>
		<div class="block">
			<div class="container">
				<h3><?php echo esc_html( $data['title'] ); ?></h3>

				<div class="button blue upload-model margin"
							data-id="<?php esc_attr( 0 ); ?>"
							data-type="<?php echo esc_attr( $key ); ?>"
							data-action="set_model"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'associate_file' ) ); ?>">
					<i class="fas fa-upload fa-fw"></i>
					<span><?php esc_html_e( 'Envoyer votre modèle personnalisé', 'digirisk' ); ?></span>
				</div>

				<ul class="margin">
					<li>
						<a href="<?php echo esc_attr( $list_document_default[ $key ]['url'] ); ?>"><i class="dashicons-download dashicons"></i>Télécharger le modèle courant</a>
					</li>
					<li>
						<a href="#" class="wpeo-modal-event"
							data-action="view_historic_model"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'view_historic_model' ) ); ?>"
							data-parent="block"
							data-target="popup"
							data-title="<?php echo esc_attr( 'Historique des modèles: ' . $data['title'] ); ?>"
							data-type="<?php echo esc_attr( $key ); ?>"
							data-class="<?php echo esc_attr( $data['class'] ); ?>"><span class="dashicons dashicons-visibility"></span><?php esc_html_e( 'Historique du modèle', 'digirisk' ); ?></a>
					</li>
					<li>
						<a href="#" class="action-attribute"
							data-action="reset_default_model"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'reset_default_model' ) ); ?>"
							data-type="<?php echo esc_attr( $key ); ?>"
							data-class="<?php echo esc_attr( $data['class'] ); ?>"
							data-confirm="<?php echo esc_attr( 'Êtes vous sur de vouloir réinitialiser le modèle par défaut' ); ?>"><span class="dashicons dashicons-edit"></span>Réinitialiser le modèle par défaut</a>
					</li>

					<?php echo apply_filters( 'digi_handle_model_actions_end', '', $key ); ?>
				</ul>
			</div>
		</div>
		<?php
	endforeach;
endif;
?>
