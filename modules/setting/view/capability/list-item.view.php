<?php
/**
 * Affichage de la liste des utilisateurs pour affecter les capacités
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// create_causerie
// manage_causerie
// manage_prevention_plan
//
?>

<tr class="user-row">
	<td><div class="avatar" style="background-color: #<?php echo esc_attr( $user->data['avatar_color'] ); ?>;"><span><?php echo esc_html( $user->data['initial'] ); ?></span></div></td>
	<td class="padding"><span><strong><?php echo esc_html( \eoxia\User_Class::g()->element_prefix . $user->data['id'] ); ?><strong></span></td>
	<td class="padding"><span><?php echo esc_html( $user->data['lastname'] ); ?></span></td>
	<td class="padding"><span><?php echo esc_html( $user->data['firstname'] ); ?></span></td>
	<td class="padding">
		<span><?php echo esc_html( $user->data['email'] ); ?></span>
		<?php echo apply_filters( 'digi_user_dashboard_item_email_after' , $user ); ?>
	</td>
	<td class="padding"><span><?php echo esc_html( implode( ', ', $user->data['wordpress_user']->roles ) ); ?></span></td>
	<td>
		<input class="all" <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_digirisk' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_digirisk]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_du' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_du]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_accident' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_accident]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_causerie' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_causerie]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_prevention' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_prevention]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_permis_feu' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_permis_feu]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_listing_risque' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_listing_risque]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_sorter' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_sorter]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_users' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_users]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_tools' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_tools]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
	<td>
		<input <?php echo ( $user->data['wordpress_user']->has_cap( 'manage_setting' ) ) ? 'checked' : ''; ?>
			name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability][manage_setting]"
			id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>" type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"></label>
	</td>
</tr>
