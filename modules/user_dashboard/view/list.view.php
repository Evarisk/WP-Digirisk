<?php
/**
 * La liste des utilisateurs
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

	<thead>
		<tr>
			<td></td>
			<td><?php esc_html_e( 'ID', 'digirisk' ); ?></td>
			<td><?php esc_html_e( 'Lastname', 'digirisk' ); ?></td>
			<td><?php esc_html_e( 'Firtname', 'digirisk' ); ?></td>
			<td><?php esc_html_e( 'Email', 'digirisk' ); ?></td>
			<td></td>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $list_user ) ) :
			foreach ( $list_user as $user ) :
				view_util::exec( 'user_dashboard', 'item', array( 'user' => $user ) );
			endforeach;
		endif;
		?>
	</tbody>
