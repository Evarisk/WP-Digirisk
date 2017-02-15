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
	<h3><?php esc_html_e( 'Bienvenue, sur DigiRisk, on vous suggère quelques étapes pour la mise en place du Document Unique', 'digirisk' ); ?></h3>
	<ul class="grid-layout w2">
		<li>
			<h4><?php esc_html_e( 'Préparer la démarche', 'digirisk' ); ?></h4>
			<ul>
				<li>Récupérer les documents</li>
				<li>Présenter la démarche</li>
				<li>Informer le personnel</li>
			</ul>

			<h4><?php esc_html_e( 'Evaluer les risques', 'digirisk' ); ?></h4>
			<ul>
				<li>Définir la méthodologie</li>
				<li>Réaliser votre arborescence d'Unités de Travail</li>
				<li>Evaluer vos risques</li>
				<li>Impliquer votre personnel</li>
			</ul>

			<h4><?php esc_html_e( 'Elaborer un programme', 'digirisk' ); ?></h4>
			<ul>
				<li>Hiérarchiser vos risques</li>
				<li>Budgéter vos actions</li>
			</ul>

			<h4><?php esc_html_e( 'Mettre en oeuvre les actions', 'digirisk' ); ?></h4>
			<ul>
				<li>Réaliser vos actions</li>
				<li>Impliquer votre personnel</li>
			</ul>

			<h4>Ré-évaluer les risques</h4>
			<ul>
				<li>Valider l'efficacité de vos actions</li>
			</ul>
		</li>

		<li><img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/01.png' ); ?>" alt="01" /></li>
	</ul>
</div>
