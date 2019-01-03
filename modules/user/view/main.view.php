<?php
/**
 * La vue contenant les deux blocs pour afficher les utilisateurs à affecter.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.3.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<section class="users wpeo-gridlayout grid-2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>
		<?php do_shortcode( '[digi-search id="' . $workunit->id . '" icon="dashicons dashicons-search" next-action="display_user_affected" type="user" target="affected-users"]' ); ?>
		<!-- La liste des utilisateurs affectés -->
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'user', 'list-user-affected', array(
			'workunit'           => $workunit,
			'list_affected_user' => $list_affected_user,
		) );
		?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>

		<?php do_shortcode( '[digi-search id="' . $workunit->id . '" icon="dashicons dashicons-search" next-action="display_user_assigned" type="user" target="form-edit-user-assign"]' ); ?>
		<!-- La liste des utilisateurs à affecter -->
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'user', 'list-user-to-assign', array(
			'workunit'         => $workunit,
			'current_page'     => $current_page,
			'number_page'      => $number_page,
			'users'            => $list_user_to_assign,
			'list_affected_id' => $list_affected_id,
		) );
		?>
	</div>
</section>
