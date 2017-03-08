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
	<h2><?php esc_html_e( 'Les pictogrammes de signalisation de l’INRS', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( 'Le saviez-vous ?', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'L’INRS met à votre disposition 2 guides pour la signalisation:', 'digirisk' ); ?>
			<ul>
				<li><?php esc_html_e( 'ED 777 : Signalisation de santé et de sécurité au travail. Réglementation.', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'ED 885 : La signalisation de santé et de sécurité au travail', 'digirisk' ); ?></li>
			</ul>
			<p><?php esc_html_e( 'Les pictogrammes originaux sont aussi disponibles sur leur site: http://www.inrs.fr/media.html?refINRS=outil10', 'digirisk' ); ?>

		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/07.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
