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
 *
 */

namespace digi;

/**
 * @var Society_Model $society             La société.
 * @var integer       $selected_society_id L'ID de la société actuellement séléctionnée.
 * @var Society_Model[] $societies         Les sociétés enfant de la société principale.
 */

defined( 'ABSPATH' ) || exit; ?>

<div class="navigation-container">
	<?php
	\eoxia\View_Util::exec( 'digirisk', 'navigation', 'header', array(
		'society' => $society,
	) );

	\eoxia\View_Util::exec( 'digirisk', 'navigation', 'list', array(
		'selected_society_id' => $selected_society_id,
		'societies'           => $societies,
		'id'                  => $society->ID,
		'society'             => $society,
		'with_children'       => $with_children,
		'class'               => 'workunit-list',
	) );
	?>
</div>
