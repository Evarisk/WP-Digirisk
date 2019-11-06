<?php
/**
 * Vue principale de l'application
 * Exécutes deux shortcodes:
 *
 * [digi_navigation] pour afficher la navigation entre les différentes sociétés créées dans DigiRisk.
 * [digi_application] pour afficher l'application DigiRisk.
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

<div class="digirisk-wrap wpeo-wrap" style="clear: both;">
	<?php
	echo do_shortcode( '[digi_navigation id="' . $id . '"]' );
	echo do_shortcode( '[digi_application id="' . $id . '"]' );
	?>
</div>
