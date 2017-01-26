<?php
/**
 * Affichages le contenu de la page outils de Digirisk dans WordPress.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.5.0
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

			<div id="digi-data-export" class="wp-digi-bloc-loader gridwrapper2" >
				<div class="block">
					<?php echo do_shortcode( '[digi-export]' ); ?>
				</div>
				<div class="block">
					<?php echo do_shortcode( '[digi-import]' ); ?>
				</div>
			</div>


			<div id="digi-handle-model" class="wp-digi-bloc-loader gridwrapper2 hidden" >
				<?php echo do_shortcode( '[digi-handle-model]' ); ?>
			</div>

			<div id="digi-data-import-user" class="wp-digi-bloc-loader gridwrapper2 hidden" >
				<?php echo do_shortcode( '[digi-import-user]' ); ?>
			</div>

			<div id="digi-more" class="hidden">
				<div class="block">
					<p><?php esc_html_e( 'Cliquer sur ce bouton pour que Digirisk réintialise les anciennes variables de la méthode d\'évaluation d\'Evarisk.', 'digirisk' ); ?></p>
					<p><button class="wp-digi-bton-fourth reset-method-evaluation" data-nonce="<?php echo esc_attr( wp_create_nonce( 'reset_methodesc_html_evaluation' ) ); ?>" type="button"><?php esc_html_e( 'Réintialiser', 'digirisk' ); ?></button>
					<ul></ul>
				</div>

				<div class="block">
					<p><?php esc_html_e( 'Cliquer sur ce bouton pour résoudre les problèmes de recommendation', 'digirisk' ); ?></p>
					<p><button class="wp-digi-bton-fourth fix-recommendation" data-nonce="<?php echo esc_attr( wp_create_nonce( 'fix_recommendation' ) ); ?>" type="button"><?php esc_html_e( 'Résoudre', 'digirisk' ); ?></button>
					<ul></ul>
				</div>

				<div class="block">
					<p><?php esc_html_e( 'Cliquer sur ce bouton pour migrer les documents', 'digirisk' ); ?></p>
					<p><button class="wp-digi-bton-fourth fix-doc" data-nonce="<?php echo esc_attr( wp_create_nonce( 'callback_transfert_doc' ) ); ?>" type="button"><?php esc_html_e( 'Résoudre', 'digirisk' ); ?></button>
					<ul></ul>
				</div>

				<div class="block">
					<p><?php esc_html_e( 'Cliquer sur ce bouton pour que recompiler les risques, si vous rencontrez des problèmes d\'affichage', 'digirisk' ); ?></p>
					<p><button class="wp-digi-bton-fourth element-risk-compilation" data-nonce="<?php echo esc_attr( wp_create_nonce( 'risk_list_compil' ) ); ?>" type="button" ><?php esc_html_e( 'Recompiler', 'digirisk' ); ?></button>
					<ul></ul>
				</div>
			</div>
		</div>

	</div><!-- .digirisk-wrap -->
</div>
