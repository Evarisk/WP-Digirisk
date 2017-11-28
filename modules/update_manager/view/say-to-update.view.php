<?php
/**
 * La vue affichant à l'utilisateur de mêttre à jour DigiRisk.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="popup popup-update-manager active no-close">
	<div class="container">
		<div class="header">
			<h2 class="title"><?php echo esc_html_e( 'Mise à jour requise', 'digirisk' ); ?></h2>
		</div>
		<div class="content">
			<p style="font-size: 1.4em; margin-bottom: 10px;"><?php esc_html_e( 'Le logiciel DigiRisk nécessite une mise à jour des données.', 'digirisk' ); ?></p>
			<p style="font-size: 1.4em;"><?php esc_html_e( 'Attention, interrompre la procédure de mise à jour entrainera une perte de vos données.', 'digirisk' ); ?></p>

			<p style="text-align: center; margin-top: 20px;">
				<a class="button blue" href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-update' ) ); ?>">
					<span><?php esc_html_e( 'Lancer la mise à jour', 'digirisk' ); ?></span>
				</a>
				<a class="back-update" href="<?php echo esc_attr( admin_url( 'index.php' ) ); ?>"><?php esc_html_e( 'Retour', 'digirisk' ); ?></a>
			</p>
		</div>
	</div>
</div>
