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
	<h2><?php esc_html_e( 'Nous installons, les risques par défaut, basés sur les 17 familles de risques proposées par l’INRS qui sont consultables dans le document : ED 840', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( 'Le saviez-vous ?', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'Digirisk contient quelques familles de risques complémentaires:', 'digirisk' ); ?></p>
			<ul>
				<li><?php esc_html_e( 'Amiante', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Les risques présents pour la pénibilité', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Certains anciens risques de l’ED 840', 'digirisk' ); ?></li>
			</ul>

			<p><?php esc_html_e( 'S\'il vous en manque il y a toujours la catégorie “autres”', 'digirisk' ); ?></p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/06.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
