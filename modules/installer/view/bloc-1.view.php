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
	<h2><?php esc_html_e( 'Bienvenue, sur DigiRisk, on finalise votre installation !', 'digirisk' ); ?></h2>
	<div class="grid-layout w2">
		<div class="content">
			<h3 class="center"><?php esc_html_e( 'Le Document Unique est obligatoire depuis le 5 Novembre 2001', 'digirisk' ); ?></h3>
			<p class="center"><a href="https://www.legifrance.gouv.fr/affichTexte.do?cidTexte=JORFTEXT000000408526&categorieLien=id" class="center" target="_blank"><?php esc_html_e( 'Le décret du 5 Novembre 2001', 'dogirisk' ); ?></a></p>
			<p class="light oversize center"><?php esc_html_e( 'Avec DigiRisk cela devient simple !', 'digirisk' ); ?></p>
		</div>

		<div>
			<img src="<?php echo esc_attr( PLUGIN_DIGIRISK_URL . 'core/assets/images/installer/01.jpg' ); ?>" alt="01" />
		</div>
	</div>
</div>
