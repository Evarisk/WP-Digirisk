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
	<h2><?php esc_html_e( 'La méthode d’évaluation des risques avancée', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3><?php esc_html_e( 'La méthode avancée', 'digirisk' ); ?></h3>
			<p><?php esc_html_e( 'Elle est basée sur le modèle de classement de KINNEY', 'digirisk' ); ?></p>
			<p class="center oversize strong">
				<?php esc_html_e( 'Risque', 'digirisk' ); ?><br>
				<?php esc_html_e( '=', 'digirisk' ); ?><br>
				<?php esc_html_e( 'Gravité * Exposition * Probabilité', 'digirisk' ); ?>
			</p>
			<p><?php esc_html_e( 'Mais avec 5 critères', 'digirisk' ); ?></p>
			<ul>
				<li><?php esc_html_e( 'Gravité de 0 à 4', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Exposition de 0 à 4', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Occurrence de 1 à 4', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Formation de 1 à 4', 'digirisk' ); ?></li>
				<li><?php esc_html_e( 'Protection de 1 à 4', 'digirisk' ); ?></li>
			</ul>
			<p><?php esc_html_e( '*P : La probabilité intègre 3 critères', 'digirisk' ); ?></p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/05.jpg' ); ?>" alt="05" />
		</div>
	</div>
</div>
