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
	<h2><?php esc_html_e( 'Le saviez-vous ?', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<p class="oversize center light"><?php esc_html_e( 'Le risque, c\'est le Danger et l\'Homme dans le même espace', 'digirisk' ); ?></p>
			<p class="center">
				<a href="http://www.larousse.fr/dictionnaires/francais/risque/69557#8VAKqHCtvXCADLK3.99" target="_blank"><?php esc_html_e( 'Définition du Larousse', 'digirisk' ); ?></a>
			</p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/03.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
