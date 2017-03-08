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
	<h2><?php esc_html_e( 'La méthode simplifiée vous permet une cotation sur 4 niveaux', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( 'Le saviez-vous ?', 'digirisk' ); ?></h3>

			<p><?php _e( '<b>La cotation risque faible</b>, notamment dans le cas des expositions à des produits chimiques, a une signification juridique.', 'digirisk' ); ?></p>
			<p>
				<?php _e( 'En effet, la définition d\'un risque faible doit respecter une définition légale. Retrouvez les informations ici:', 'digirisk' ); ?>
				<a href="http://www.travailler-mieux.gouv.fr/" target="_blank">travailler-mieux.gouv.fr</a>
			</p>
			<p><?php _e( '<b>L\'échelle</b> des cotations du logiciel DigiRisk Comprend au maximum 101 valeurs comprises entre 0 et 100.', 'digirisk' ); ?></p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/04.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
