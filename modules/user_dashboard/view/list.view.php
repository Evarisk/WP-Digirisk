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

<thead>
	<tr>
		<td class="w50"></td>
		<td class="w50 padding">
			<?php esc_html_e( 'ID', 'digirisk' ); ?>
		</td>
		<td class="padding">
			<?php esc_html_e( 'Lastname', 'digirisk' ); ?>
			<span class="tooltip hover red required" aria-label="<?php esc_attr_e( 'Ce champ est obligatoire', 'digirisk' ); ?>">*</span>
		</td>
		<td class="padding">
			<?php esc_html_e( 'Firtname', 'digirisk' ); ?>
			<span class="tooltip hover red" aria-label="<?php esc_attr_e( 'Ce champ est obligatoire', 'digirisk' ); ?>">*</span>
		</td>
		<td class="padding">
			<?php esc_html_e( 'Email', 'digirisk' ); ?>
			<span class="tooltip hover red" aria-label="<?php esc_attr_e( 'Ce champ est obligatoire', 'digirisk' ); ?>">*</span>
		</td>
		<td class="w100"></td>
	</tr>
</thead>

<tbody>
	<?php
	if ( ! empty( $list_user ) ) :
		foreach ( $list_user as $user ) :
			\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'item', array( 'user' => $user ) );
		endforeach;
	endif;

	// Formulaire d'édition pour une nouvelle entrée.
	\eoxia\View_Util::exec( 'digirisk', 'user_dashboard', 'item-edit', array( 'user' => $user_schema ) );
	?>
</tbody>
