<?php
/**
 * Le template pour afficher le menu de navigation.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<div class="navigation-container">
	<?php
	\eoxia\View_Util::exec( 'digirisk', 'navigation', 'header', array(
		'society' => $society,
	) );

	\eoxia\View_Util::exec( 'digirisk', 'navigation', 'list', array(
		'selected_society_id' => $selected_society_id,
		'societies'           => $societies,
		'id'                  => $society->data['id'],
		'class'               => 'workunit-list',
	) );
	?>
</div>
