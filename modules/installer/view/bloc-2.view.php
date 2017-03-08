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
	<h2><?php esc_html_e( 'Nous installons les fonctions de gestion des Unités de Travail et des Groupements', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">

		<div class="content">
			<h3><?php esc_html_e( 'Au fait, Connaissez-vous la définition d’une Unité de Travail selon l’INRS ?', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'Regroupement (géographique, par métier, par poste, par activité) opéré dans l’entreprise sur la base des “ contextes homogènes d’exposition ” utilisés pour circonscrire l’évaluation et en rendre compte (traçabilité) de l’évaluation des risques.', 'digirisk' ); ?></p>
			<p><?php esc_html_e( 'Vous pouvez télécharger : ED887.pdf', 'digirisk' ); ?></p>

			<h3><?php esc_html_e( 'Définition des Unités de Travail Ministère du travail', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'La notion d’« unité de travail » doit être comprise au sens large, afin de recouvrir les situations très diverses d’organisation du travail. Son champ peut s’étendre d’un poste de travail, à plusieurs types de postes occupés par les travailleurs ou à des situations de travail présentant les mêmes caractéristiques. De même, d’un point de vue géographique, l’unité de travail ne se limite pas forcément à une activité fixe, mais peut aussi bien couvrir des lieux différents (manutention, chantiers, transports, etc.).', 'digirisk' ); ?></p>
			<p><a href="http://travail-emploi.gouv.fr/publications/picts/bo/05062002/A0100004.htm" target="_blank">Bulletin Officiel du Travail, de l’Emploi et de la Formation Professionnelle</a></p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/02.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
