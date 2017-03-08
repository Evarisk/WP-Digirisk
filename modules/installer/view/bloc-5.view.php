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
	<h2><?php esc_html_e( 'Nous installons la méthode d’évaluation avancée', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( 'Le saviez-vous ?', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'La méthode d’évaluation des risques détaillée proposée est basée sur le modèle de classement de KINNEY', 'digirisk' ); ?></p>
			<p style="text-align: center;"><strong><?php esc_html_e( 'Risque', 'digirisk' ); ?></strong></p>
			<p style="text-align: center;"><strong><?php esc_html_e( '=', 'digirisk' ); ?></strong></p>
			<p style="text-align: center;"><strong><?php esc_html_e( 'Gravité * Exposition * Probabilité', 'digirisk' ); ?></strong></p>

			<p><?php esc_html_e( 'P : La probabilité intègre 3 critères:', 'digirisk' ); ?></p>
			<ul>
				<li><?php esc_html_e( 'Occurrence de 1 à 4', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Formation de 1 à 4', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Protection de 1 à 4', 'digirisk' ); ?></li>
			</ul>

			<p><?php esc_html_e( 'Ces critères sont multipliés. ', 'digirisk' ); ?></p>
			<p><?php esc_html_e( 'On obtient des valeurs de 0 à 1024 que l\'on ramène sur l\'échelle de 0 à 100.', 'digirisk' ); ?></p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/05.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
