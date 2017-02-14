<?php
/**
 * Affiches le résumé de la société.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.6.0
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; }

?>
<div class="grid-layout w2">
	<div>
		<h2>Les risques ajoutés</h2>
		<?php
		View_Util::exec( 'society', 'historic/table', array(
			'risks' => $added_risks,
		) );
		?>
	</div>

	<div>
		<h2>Les risques supprimés</h2>
		<?php
		View_Util::exec( 'society', 'historic/table', array(
			'risks' => $added_risks,
		) );
		?>
	</div>

	<div>
		<h2>Les risques ajoutés avec une cotation noir</h2>
		<?php
		View_Util::exec( 'society', 'historic/table', array(
			'risks' => $added_risks_in_cotation,
		) );
		?>
	</div>

	<div>
		<h2>Les risques ajoutés avec une cotation rouge</h2>
		<?php
		View_Util::exec( 'society', 'historic/table', array(
			'risks' => $added_risks,
		) );
		?>
	</div>

	<div>
		<h2>Les risques ajoutés avec une cotation orange</h2>
		<?php
		View_Util::exec( 'society', 'historic/table', array(
			'risks' => $added_risks,
		) );
		?>
	</div>
</div>
