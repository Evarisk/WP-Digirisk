<?php
/**
 * Affichages le contenu de la page outils de Digirisk dans WordPress.
 *
 * @author Evarisk <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package tools
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="wrap wpeo-wrap">
	<h1><?php esc_html_e( 'DigiRisk outils', 'digirisk' ); ?></h1>

	<div class="wpeo-tab">
		<ul class="tab-list">
			<li class="tab-element tab-active" data-target="digi-data-export" ><?php esc_html_e( 'Export digirisk datas', 'digirisk' ); ?></li>
			<li class="tab-element" data-target="digi-handle-model" ><?php esc_html_e( 'Modèles ODT', 'digirisk' ); ?></a>
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
		</div>
	</div>

</div>
