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
	<h2><?php esc_html_e( 'Nous installons les fonctions de gestion des Unités de Travail', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">

		<div class="content">
			<h3><?php esc_html_e( 'Comment définir vos Unités de Travail ?', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'En regroupement par', 'digirisk' ); ?><br><span class="strong"><?php esc_html_e( 'géographie, métiers, postes, activités', 'digirisk' ); ?></span></p>
			<p><?php esc_html_e( 'basé sur des', 'digirisk' ); ?><br><span class="strong"><?php esc_html_e( 'contextes homogènes d’expositions', 'digirisk' ); ?></span></p>
			<p><?php esc_html_e( 'Assurant la', 'digirisk' ); ?><br><span class="strong"><?php esc_html_e( 'traçabilité', 'digirisk' ); ?></span></p>
			<p><?php esc_html_e( 'de l’évaluation des risques.', 'digirisk' ); ?></p>
			<ul>
				<li><a href="http://www.inrs.fr/media.html?refINRS=ED%20887" target="_blank"><?php esc_html_e( 'Guide pour le DUER de l’INRS : ED887.pdf', 'digirisk' ); ?></a></li>
				<li><a href="http://travail-emploi.gouv.fr/publications/picts/bo/05062002/A0100004.htm" target="_blank"><?php esc_html_e( 'Définition des Unités de Travail Ministère du travail', 'digirisk' ); ?></a></li>
			</ul>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/02.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
