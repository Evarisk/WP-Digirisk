<?php
/**
 * Le bloc de présentation lors de l'installation
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.7.0
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package installer
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<div>
	<h2><?php esc_html_e( 'La méthode d\'évaluation des risques simplifiée', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( 'La méthode simplifiée', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'Cette méthode permet cependant de noter les résultats d’autres méthodes plus complexes comme', 'digirisk' ); ?></p>
			<ul>
				<li><?php esc_html_e( 'Les risques chimiques', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Le niveau d\'empoussièrement pour l\'amiante', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Les résultats du questionnaire de Karasek', 'digirisk' ); ?></li>
			</ul>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/04.jpg' ); ?>" alt="04" />
		</div>
	</div>
</div>
