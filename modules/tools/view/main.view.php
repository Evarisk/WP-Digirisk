<?php
/**
 * Affichages le contenu de la page outils de Digirisk dans WordPress.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package tools
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap wpeo-wrap">
	<h1><?php esc_html_e( 'DigiRisk outils', 'digirisk' ); ?></h1>

	<div class="wpeo-tab">
		<ul class="tab-list">
			<li class="tab-element tab-active" data-target="digi-data-export" ><?php esc_html_e( 'Export digirisk datas', 'digirisk' ); ?></li>
			<li class="tab-element" data-target="digi-handle-model" ><?php esc_html_e( 'Modèles ODT', 'digirisk' ); ?></a>
			<li class="tab-element" style="margin-left: auto;" data-target="digi-advanced" ><?php esc_html_e( 'Avancés', 'digirisk' ); ?></a>
		</ul>

		<div class="tab-container digirisk-wrap digi-tools-main-container">
			<div id="digi-data-export" class="tab-content tab-active wpeo-gridlayout padding grid-2" >
				<div class="block">
					<div class="container">
						<?php echo do_shortcode( '[digi-export]' ); ?>
					</div>
				</div>

				<div class="block">
					<div class="container">
						<?php echo do_shortcode( '[digi-import]' ); ?>
					</div>
				</div>

				<div class="block">
					<div class="container">
						<?php \eoxia\View_Util::exec( 'digirisk', 'export_import', 'export-csv' ); ?>
					</div>
				</div>
			</div>


			<div id="digi-handle-model" class="tab-content wpeo-gridlayout grid-2 hidden" style="display: none;" >
				<?php echo do_shortcode( '[digi-handle-model]' ); ?>
			</div>

			<div id="digi-data-import-user" class="tab-content hidden" >
				<?php echo do_shortcode( '[digi-import-user]' ); ?>
			</div>

			<div id="digi-advanced" class="tab-content hidden wpeo-gridlayout grid-2">
				<div class="block">
					<form action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>" method="POST" id="digi-fix-hidden-society" >
						<h3><?php esc_html_e( 'Réparer les sociétées invisibles', 'digirisk' ); ?></h3>

						<div class="content">
							<input type="hidden" name="action" value="fix_hidden_society" />
							<?php wp_nonce_field( 'fix_hidden_society' ); ?>

							<span class="digi-fix-hidden-society-message" ><?php esc_attr_e( 'Réparer les sociétés invisibles générées dans vos DUER.', 'digirisk' ); ?></span>
							<progress value="0" max="100">0%</progress>
							<span class="digi-fix-hidden-society-detail"></span>
						</div>

						<div class="wpeo-button button-main action-input" data-parent="tab-content">
							<span><?php esc_html_e( 'Réparer', 'digirisk' ); ?></span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
