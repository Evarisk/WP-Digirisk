<?php
/**
 * Le template contenant la liste des utilisateurs dans le tableau de la page "digirisk-users".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.3
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="table-row table-header">
	<div class="table-cell table-50"><?php esc_html_e( 'Initiale', 'digirisk' ); ?></div>
	<div class="table-cell table-50"><?php esc_html_e( 'ID', 'digirisk' ); ?></div>
	<div class="table-cell table-150">
		<?php esc_html_e( 'Lastname', 'digirisk' ); ?>
		<span class="tooltip hover red required" aria-label="<?php esc_attr_e( 'This field is required', 'digirisk' ); ?>">*</span>
	</div>
	<div class="table-cell table-150">
		<?php esc_html_e( 'Firtname', 'digirisk' ); ?>
		<span class="tooltip hover red required" aria-label="<?php esc_attr_e( 'This field is required', 'digirisk' ); ?>">*</span>
	</div>
	<div class="table-cell">
		<?php esc_html_e( 'Email', 'digirisk' ); ?>
		<span class="tooltip hover red required" aria-label="<?php esc_attr_e( 'This field is required', 'digirisk' ); ?>">*</span>
	</div>
	<div class="table-cell table-150 table-end"></div>
</div>

<?php
if ( ! empty( $list_user ) ) :
	foreach ( $list_user as $user ) :
		\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'item', array( 'user' => $user ) );
	endforeach;
endif;

// Formulaire d'édition pour une nouvelle entrée.
\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'item-edit', array( 'user' => $user_schema ) );
?>
