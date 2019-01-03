<?php
/**
 * Le template de la modal affichant les établissements où l'utilisateur est affecté.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.1.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<p>L'utilisateur <strong><?Php echo esc_html( $user->data['displayname'] ); ?></strong> est affecté aux établissements suivants:</p>

<table class="wpeo-table">
	<thead>
		<tr>
			<th data-title="Identifiant">#</th>
			<th data-title="Nom">Nom</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ( ! empty( $affected_groups ) ) :
			foreach ( $affected_groups as $affected_group ) :
				?>
				<tr>
					<td data-title="Identifiant"><?php echo $affected_group->data['unique_identifier']; ?></td>
					<td data-title="Nom"><a target="_blank" href="<?php echo admin_url( 'admin.php?page=digirisk-simple-risk-evaluation&society_id=' . $affected_group->data['id'] ); ?>"><?php echo $affected_group->data['title']; ?></a></td>
				</tr>
				<?php
			endforeach;
		else :
			?>
			<tr>
				<td colspan="2"><?php esc_html_e( 'Cet utilisateur n\'est affecté à aucun établissement', 'digirisk' ); ?></td>
			</tr>
			<?php
		endif;
		?>
	</tbody>
</table>
