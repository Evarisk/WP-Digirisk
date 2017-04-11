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
	<h2><?php esc_html_e( 'DigiRisk propose 2 méthodes d\'évaluation des risques', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( 'La méthode simplifiée', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( '4 Priorités ! Gris, Orange, Rouge et Noir', 'digirisk' ); ?></p>
			<h3><?php esc_html_e( 'La méthode avancée', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'Basée sur la méthode de Kinney', 'digirisk' ); ?></p>
			<p class="padding center oversize light"><?php esc_html_e( 'Risque  = Gravité * Exposition * Probabilité', 'digirisk' ); ?></p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/01.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
