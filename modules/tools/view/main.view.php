<?php
/**
 * Affichages le contenu de la page outils de Digirisk dans WordPress.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap">
	<h1><?php esc_html_e( 'Digirisk tools', 'digirisk' ); ?></h1>

	<div class="digi-tools-main-container">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active" href="#" data-id="digi-data-export" ><?php esc_html_e( 'Export digirisk datas', 'digirisk' ); ?></a>
			<a class="nav-tab" href="#" data-id="digi-handle-model" ><?php esc_html_e( 'Modèles ODT', 'digirisk' ); ?></a>
			<a class="nav-tab hidden" href="#" data-id="digi-data-import-user" ><?php esc_html_e( 'Importer des utilisateurs', 'digirisk' ); ?></a>
			<?php apply_filters( 'digi_tools_interface_tabs', '' ); ?>
			<a class="nav-tab" href="#" data-id="digi-more"><?php esc_html_e( 'Avancés', 'digirisk' ); ?></a>
		</h2>

		<div class="digirisk-wrap">

			<div id="digi-data-export" class="tab-content grid-layout padding w2">
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
						<?php \eoxia001\View_Util::exec( 'digirisk', 'export_import', 'export-csv' ); ?>
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

				<div class="grid-layout padding w2">

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
							<h3><?php esc_html_e( 'Problèmes de signalisation', 'digirisk' ); ?></h3>
							<p class="content"><?php esc_html_e( 'Cliquer sur ce bouton pour résoudre les problèmes de signalisation', 'digirisk' ); ?></p>
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
							<p class="content"><?php esc_html_e( 'Cliquer sur ce bouton pour recompiler les données des risques, si vous rencontrez des problèmes d\'affichage', 'digirisk' ); ?></p>
							<p><button class="button blue margin element-risk-compilation" data-nonce="<?php echo esc_attr( wp_create_nonce( 'risk_list_compil' ) ); ?>" type="button" ><?php esc_html_e( 'Recompiler', 'digirisk' ); ?></button>
							<ul></ul>
						</div>
					</div>

					<div class="block">
						<div class="container">
							<h3><?php esc_html_e( 'Réinitialisation des risques prédéfinis', 'digirisk' ); ?></h3>
							<p class="content"><?php esc_html_e( 'Cliquer sur ce bouton pour réinitialiser les risques prédéfinis si vous avez des problèmes de définition.', 'digirisk' ); ?></p>
							<p><button class="button blue margin digi-risk-preset-reset" data-nonce="<?php echo esc_attr( wp_create_nonce( 'risk_preset_reset' ) ); ?>" type="button" ><?php esc_html_e( 'Réinitialiser', 'digirisk' ); ?></button>
							<ul></ul>
						</div>
					</div>

				</div> <!-- grid -->

			</div>

			<?php apply_filters( 'digi_tools_interface_content', '' ); ?>
		</div>

	</div><!-- .digirisk-wrap -->
</div>
