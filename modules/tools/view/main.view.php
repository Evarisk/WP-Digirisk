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
			<a class="nav-tab" href="#" data-id="digi-more"><?php esc_html_e( 'Avancés', 'digirisk' ); ?></a>
		</h2>

		<div class="digirisk-wrap">

			<div id="digi-data-export" class="tab-content grid-layout w2" >
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
						<?php View_Util::exec( 'export_import', 'export-csv' ); ?>
					</div>
				</div>
			</div>


			<div id="digi-handle-model" class="tab-content grid-layout w2 hidden" style="display: none;" >
				<?php echo do_shortcode( '[digi-handle-model]' ); ?>
			</div>

			<div id="digi-data-import-user" class="tab-content hidden" >
				<?php echo do_shortcode( '[digi-import-user]' ); ?>
			</div>

			<div id="digi-more" class="tab-content hidden" style="display: none;">

				<span class="fa fa-exclamation-circle"></span><i><?php esc_html_e( 'Attention, veuillez faire une sauvegarde de votre base de donnée avant toutes actions.', 'digirisk' ); ?></i>

				<div class="grid-layout w2">

					<div class="block">
						<div class="container">
							<h3><?php esc_html_e( 'Méthode d\'évaluation d\'Evarisk', 'digirisk' ); ?></h3>
							<p class="content"><?php esc_html_e( 'Cliquer sur ce bouton pour que Digirisk réintialise les anciennes variables de la méthode d\'évaluation d\'Evarisk.', 'digirisk' ); ?></p>
							<p><button class="button blue margin reset-method-evaluation" data-nonce="<?php echo esc_attr( wp_create_nonce( 'reset_method_evaluation' ) ); ?>" type="button"><?php esc_html_e( 'Réintialiser', 'digirisk' ); ?></button>
							<ul></ul>
						</div>
					</div>

					<div class="block">
						<div class="container">
							<h3><?php esc_html_e( 'Problèmes de recommendation', 'digirisk' ); ?></h3>
							<p class="content"><?php esc_html_e( 'Cliquer sur ce bouton pour résoudre les problèmes de recommendation', 'digirisk' ); ?></p>
							<p><button class="button blue margin fix-recommendation" data-nonce="<?php echo esc_attr( wp_create_nonce( 'fix_recommendation' ) ); ?>" type="button"><?php esc_html_e( 'Résoudre', 'digirisk' ); ?></button>
							<ul></ul>
						</div>
					</div>

					<div class="block">
						<div class="container">
							<h3><?php esc_html_e( 'Migration de document', 'digirisk' ); ?></h3>
							<p class="content"><?php esc_html_e( 'Cliquer sur ce bouton pour migrer les documents', 'digirisk' ); ?></p>
							<p><button class="button blue margin fix-doc" data-nonce="<?php echo esc_attr( wp_create_nonce( 'callback_transfert_doc' ) ); ?>" type="button"><?php esc_html_e( 'Résoudre', 'digirisk' ); ?></button>
							<ul></ul>
						</div>
					</div>

					<div class="block">
						<div class="container">
							<h3><?php esc_html_e( 'En cas de problèmes d\'affichage', 'digirisk' ); ?></h3>
							<p class="content"><?php esc_html_e( 'Cliquer sur ce bouton pour que recompiler les risques, si vous rencontrez des problèmes d\'affichage', 'digirisk' ); ?></p>
							<p><button class="button blue margin element-risk-compilation" data-nonce="<?php echo esc_attr( wp_create_nonce( 'risk_list_compil' ) ); ?>" type="button" ><?php esc_html_e( 'Recompiler', 'digirisk' ); ?></button>
							<ul></ul>
						</div>
					</div>

			</div> <!-- grid -->

			</div>
		</div>

	</div><!-- .digirisk-wrap -->
</div>
