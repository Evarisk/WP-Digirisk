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
			<h2 class="title"><?php echo esc_html_e( 'Mise à jour de vos données obligatoires', 'digirisk' ); ?></h2>
		</div>
		<div class="content">
			<p><?php esc_html_e( 'Attention: vous ne devez pas quitter la page de mise à jour, dans le cas contraire vos données peuvent être corrompues.', 'digirisk' ); ?></p>
			<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-update' ) ); ?>"><?php esc_html_e( 'Lancer la mise à jour', 'digirisk' ); ?></a>
			<a href="<?php echo esc_attr( admin_url( 'index.php' ) ); ?>"><?php esc_html_e( 'Retour', 'digirisk' ); ?></a>
		</div>
	</div>
</div>
