<?php
/**
 * Affichage d'un champ texte pour modifier l'accronyme.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2019 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<li>
	<label for="accronym-<?php echo $key; ?>"><?php echo $key; ?>
		<span>(<?php echo $element['description']; ?>)</span>
		<input type="text" id="accronym-<?php echo $key; ?>" name="list_accronym[<?php echo $key; ?>][to]" value="<?php echo $element['to']; ?>" />
	</label>
	<input type="hidden" name="list_accronym[<?php echo $key; ?>][description]" value="<?php echo $element['description']; ?>" />
</li>
