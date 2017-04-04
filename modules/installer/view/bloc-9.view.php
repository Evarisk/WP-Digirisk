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
	<h2><?php esc_html_e( 'Félicitations, l\'installation est terminée !', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( 'DigiRisk génère aussi l\'affichage légal !', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'Remplissez les champs, téléchargez votre affichage légal gratuitement au format libreoffice A3 ou A4', 'digirisk' ); ?></p>
			<ul>
				<li>
					<a href="https://fr.libreoffice.org/" target="_blank"><?php esc_html_e( 'Libre Office', 'digirisk' ); ?></a>
					<?php esc_html_e( ' pour lire tous les documents de DigiRisk', 'digirisk' ); ?>
				</li>
				<li><a href="https://www.service-public.fr/professionnels-entreprises/vosdroits/F23106" target="_blank"><?php esc_html_e( 'Site du gouvernement sur affichage légal', 'digirisk' ); ?></a></li>
			</ul>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/08.jpg' ); ?>" alt="08" />
		</div>
	</div>
</div>
