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
			<h3><?php esc_html_e( 'I. Préparer la démarche', 'digirisk' ); ?></h3>
			<ul>
				<li>Récupérer les documents</li>
				<li>Présenter la démarche</li>
				<li>Informer le personnel</li>
			</ul>

			<h3><?php esc_html_e( 'II. Préparer la démarche', 'digirisk' ); ?></h3>
			<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam convallis libero eget scelerisque congue. Aenean sed ultrices ipsum. Curabitur ac varius leo. Duis nibh nulla, pellentesque in finibus sit amet, posuere eu ligula. Praesent nec purus venenatis, lobortis felis blandit, sollicitudin erat. Cras vel nunc feugiat, accumsan quam nec, egestas augue. Donec dignissim molestie turpis et fringilla. Maecenas dignissim, nisl ut maximus porttitor, elit eros vestibulum dolor, ut malesuada diam turpis at mauris.
			</p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/01.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
