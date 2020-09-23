<?php
/**
 * Template permettant d'afficher la liste des fiches de groupement ou de poste.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.1.9
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="table-row table-header">
	<div class="table-cell table-75"><?php esc_html_e( 'Ref', 'digirisk' ); ?></div>
	<div class="table-cell table-500"><?php esc_html_e( 'Nom', 'digirisk' ); ?></div>
	<div class="table-cell"><?php esc_html_e( 'Date de génération', 'digirisk' ); ?></div>

	<div class="table-cell table-50 table-end"></div>
</div>

<?php if ( ! empty( $documents ) ) : ?>
	<?php foreach ( $documents as $document ) : ?>
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'document', 'list-item', array(
			'element' => $document,
		) );
		?>
	<?php endforeach; ?>
<?php else : ?>
	<div class="table-row documents-row">
		<?php echo esc_html( $_this->message['empty'] ); ?>
	</div>
<?php endif; ?>
