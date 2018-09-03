<?php
/**
 * Affichages le contenu de la page outils de Digirisk dans WordPress.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package tools
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="wrap">
	<h1><?php esc_html_e( 'Digirisk tools', 'digirisk' ); ?></h1>

	<div class="digi-tools-main-container">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active" href="#" data-id="digi-data-export" ><?php esc_html_e( 'Export digirisk datas', 'digirisk' ); ?></a>
			<a class="nav-tab" href="#" data-id="digi-handle-model" ><?php esc_html_e( 'Modèles ODT', 'digirisk' ); ?></a>
			<a class="nav-tab hidden" href="#" data-id="digi-data-import-user" ><?php esc_html_e( 'Importer des utilisateurs', 'digirisk' ); ?></a>
		</h2>

		<div class="digirisk-wrap">

			<div id="digi-data-export" class="tab-content grid-layout padding w2" >
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


			<div id="digi-handle-model" class="tab-content grid-layout w2 hidden" style="display: none;" >
				<?php echo do_shortcode( '[digi-handle-model]' ); ?>
			</div>

			<div id="digi-data-import-user" class="tab-content hidden" >
				<?php echo do_shortcode( '[digi-import-user]' ); ?>
			</div>

		</div>

	</div><!-- .digirisk-wrap -->
</div>
