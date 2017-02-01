<?php
/**
 * Affichages des boutons permettant d'envoyer les modèles ODT personnalisés
 *
 * @package Evarisk\Plugin
 *
 * @since 1.0
 * @version 6.2.5.0
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! empty( $list_type_document ) ) :
	foreach ( $list_type_document as $key => $title ) :
		?>
		<div class="block">
			<div class="container">
				<h3><?php echo esc_html( $title ); ?></h3>

				<div class="button blue upload-model margin"
							data-id="<?php esc_attr( 0 ); ?>"
							data-type="<?php echo esc_attr( $key ); ?>"
							data-title="<?php echo esc_attr( $title ); ?>"
							data-object-name="<?php echo esc_attr( $key ); ?>"
							data-action="eo_set_model"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'associate_file' ) ); ?>">
					<i class="fa fa-upload"></i>
					<span>Envoyer votre modèle personnalisé</span>
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
							data-type="<?php echo esc_attr( $key ); ?>"><span class="dashicons dashicons-visibility"></span>Historique des modèles personnalisés</a>
					</li>
					<li>
						<a href="#" class="action-attribute"
							data-action="reset_default_model"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'reset_default_model' ) ); ?>"
							data-type="<?php echo esc_attr( $key ); ?>"
							data-confirm="<?php echo esc_attr( 'Êtes vous sur de vouloir réinitialiser le modèle par défaut' ); ?>"><span class="dashicons dashicons-edit"></span>Réinitialiser le modèle par défaut</a>
					</li>
				</ul>
			</div>

			<?php View_Util::exec( 'handle_model', 'popup' ); ?>
		</div>
		<?php
	endforeach;
endif;
?>
