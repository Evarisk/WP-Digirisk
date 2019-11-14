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
	<tr>
		<th><label for="digi-hiring-date"><?php _e( 'Phone Number', 'digirisk' ); ?></label></th>
		<td class="digi-phone-user">
			<?php
				\eoxia\View_Util::exec( 'digirisk', 'user', 'user-profile-list-calling-code', array(
					'local' => get_locale(),
					'width' => '10%',
					'name'  => 'digirisk_user_information_meta[digi_phone_callingcode]'
					) );
			?>
			<input type="text" name="digirisk_user_information_meta[digi_phone_number]" id="digi-phone-number" value="<?php echo esc_attr( $phone_number ); ?>" class="regular-text eva-date" />
			<br />
		</td>
	</tr>

	<tr>
		<th><label for="digi-auto-connect-to-digirisk"><?php esc_html_e( 'Se connecter automatiquement à DigiRisk', 'digirisk' ); ?></label></th>
		<td><input type="checkbox" name="digirisk_user_information_meta[auto_connect]" id="digi-auto-connect-to-digirisk" <?php echo $auto_connect ? 'checked="checked"' : ''; ?> class="regular-text" /><br /></td>
	</tr>

	<tr>
		<th><label for="digi-modal-auto-connect-to-digirisk"><?php esc_html_e( 'Me demander de régler DigiRisk en application par défaut.', 'digirisk' ); ?></label></th>
		<td><input type="checkbox" name="digirisk_user_information_meta[ask_auto_connect]" id="digi-modal-auto-connect-to-digirisk" <?php echo $ask_auto_connect ? 'checked="checked"' : ''; ?> class="regular-text" /><br /></td>
	</tr>
</table>
