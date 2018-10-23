<?php
/**
 * La liste des utilisateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="digirisk-wrap">
	<table class="table users">
		<thead>
			<tr>
				<td class="w100 padding">
					<?php esc_html_e( 'Identifiant', 'digirisk' ); ?>
				</td>
				<td class="padding">
					<?php esc_html_e( 'Nom', 'digirisk' ); ?>
				</td>
			</tr>
		</thead>

		<tbody>
			<?php
			if ( ! empty( $affected_to ) ) :
				foreach ( $affected_to as $society ) :
					?>
					<tr>
						<td class="padding"><?php echo $society->modified_unique_identifier; ?></td>
						<td class="padding"><?php echo $society->title; ?></td>
					</tr>
					<?php
				endforeach;
			endif;
			?>
		</tbody>

	</table>
</div>
