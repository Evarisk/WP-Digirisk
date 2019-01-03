<?php
/**
 * Permet d'ajouter des champs en plus dans la page profile des utilisateurs.
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

<h3><?php _e( 'Digirisk', 'digirisk' ); ?></h3>

<table class="form-table">
	<tr>
		<th><label for="digi-hiring-date"><?php _e( 'Hiring date', 'digirisk' ); ?></label></th>
		<td><input type="text" name="digirisk_user_information_meta[digi_hiring_date]" id="digi-hiring-date" value="<?php echo esc_attr( $hiring_date ); ?>" class="regular-text eva-date" /><br /></td>
	</tr>
</table>
