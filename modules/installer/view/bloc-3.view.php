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
	<h2><?php esc_html_e( 'Connaissez-vous la différence entre risque et danger ?', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( 'Le saviez-vous ?', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'Le risque c’est le Danger et l’Homme dans le même espace.', 'digirisk' ); ?></p>
			<p><?php esc_html_e( 'Définition Risque:', 'digirisk' ); ?></p>
			<p><?php esc_html_e( 'Possibilité, probabilité d\'un fait, d\'un événement considéré comme un mal ou un dommage: Les risques de guerre augmentent.', 'digirisk' ); ?></p>
			<p><?php esc_html_e( 'Danger, inconvénient plus ou moins probable auquel on est exposé: Courir le risque d\'un échec. Un pilote qui prend trop de risques.', 'digirisk' ); ?></p>
			<p>Source: <a href="http://www.larousse.fr/dictionnaires/francais/risque/69557#8VAKqHCtvXCADLK3.99" target="_blank">larousse.fr</a></p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/03.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
