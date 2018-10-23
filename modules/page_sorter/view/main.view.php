<?php
/**
 * Vue principale contenant la liste des établissements pour gérer l'organiseur.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="wrap sorter-page">
	<form action="<?php echo esc_attr( admin_url( 'admin-post.php' ) ); ?>" method="POST">
		<input type="hidden" name="action" value="sorter_parent" />
		<?php wp_nonce_field( 'callback_sorter_parent' ); ?>
		<h1><?php esc_html_e( 'Organisation des établissements', 'digirisk' ); ?></h1>
		<div class="updated settings-error notice <?php echo $display_notice ? '' : 'hidden'; ?>">
			<p>
				<strong><?php esc_html_e( 'Organisation enregistrées.', 'digirisk' ); ?></strong>
			</p>
		</div>

		<table class="treetable">
			<caption>
				<a href="#" onclick="jQuery( '.treetable' ).treetable( 'expandAll' ); return false;">Tout déplier</a>
				<a href="#" onclick="jQuery( '.treetable' ).treetable( 'collapseAll' ); return false;">Tout replier</a>
			</caption>
			<tbody>
				<tr class="branch expanded" data-tt-id="<?php echo esc_attr( $main_society->data['id'] ); ?>" data-tt-parent-id="<?php echo esc_attr( $main_society->data['parent_id'] ); ?>">
					<td>
						<span class="<?php echo esc_attr( $main_society->data['type'] ); ?>"><?php echo esc_html( $main_society->data['title'] ); ?></span>
					</td>
				</tr>
				<?php
				\eoxia\View_Util::exec( 'digirisk', 'page_sorter', 'list', array(
					'i' => 0,
					'establishments' => $establishments,
				) );
				?>
			</tbody>
		</table>

		<input type="submit" class="button button-primary" disabled="true" value="<?php esc_html_e( 'Enregistrer', 'digirisk' ); ?>">
	</form>
</div>
