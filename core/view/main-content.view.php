<?php
/**
 * Exécutes le shortcode qui affiches le contenu principal de l'application.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="main-container">
	<div class="wpeo-tab">
		<div class="main-header">
			<div class="unit-header">
				<?php
				\eoxia\WPEO_Upload_Shortcode::g()->wpeo_upload( array(
					'id'         => $society->data['id'],
					'title'      => $society->data['unique_identifier'] . ' - ' . $society->data['title'],
					'model_name' => $society->get_class(),
					'field_name' => 'image',
					'single'     => 'false',
				) );


				require PLUGIN_DIGIRISK_PATH . '/core/view/identity.view.php';
				?>

				<div
						class="wpeo-button button-green button-square-50 action-input save"
						data-parent="unit-header"
						data-loader="digirisk-wrap"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_society' ) ); ?>"><span><i class="button-icon fas fa-save"></i></span></div>
				<div class="mobile-navigation"><i class="icon fas fa-bars"></i></div>
			</div>
		</div>

		<?php echo do_shortcode( '[digi_tab id="' . $society->data['id'] . '" type="' . $society->data['type'] . '" tab_slug="' . $tab_data->slug . '"]' ); ?>
	</div>
</div>
