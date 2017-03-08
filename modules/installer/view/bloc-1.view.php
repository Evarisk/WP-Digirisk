<?php
/**
 * Le bloc de présentation lors de l'installation
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.7.0
 * @version 6.2.7.0
 * @copyright 2015-2017 Evarisk
 * @package installer
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<div>
	<h2><?php esc_html_e( 'Bienvenue, sur DigiRisk, on vous suggère quelques étapes pour la mise en place du Document Unique', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( '1. Préparer la démarche', 'digirisk' ); ?></h3>
			<ul>
				<li><?php esc_html_e( 'Récupérer les documents', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Présenter la démarche', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Informer le personnel', 'digirisk' ); ?></li>
			</ul>

			<h3><?php esc_html_e( '2. Evaluer les risques', 'digirisk' ); ?></h3>
			<ul>
				<li><?php esc_html_e( 'Définir la méthodologie', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Réaliser votre arborescence d’Unités de Travail', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Evaluer vos risques en impliquant votre personnel', 'digirisk' ); ?></li>
			</ul>

			<h3><?php esc_html_e( '3. Elaborer un programme', 'digirisk' ); ?></h3>
			<ul>
				<li><?php esc_html_e( 'Budgétiser vos actions', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Hiérarchiser vos actions', 'digirisk' ); ?></li>
			</ul>

			<h3><?php esc_html_e( '4. Mettre en oeuvre les actions', 'digirisk' ); ?></h3>
			<ul>
				<li><?php esc_html_e( 'Réaliser vos actions', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Impliquer votre personnel', 'digirisk' ); ?></li>
			</ul>

			<h3><?php esc_html_e( '5. Ré-évaluer les risques', 'digirisk' ); ?></h3>
			<ul>
				<li><?php esc_html_e( 'Valider l’efficacité de vos actions', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Ré évaluer vos risques etc...', 'digirisk' ); ?></li>
			</ul>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/01.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
