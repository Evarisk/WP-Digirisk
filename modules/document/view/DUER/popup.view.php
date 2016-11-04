<?php namespace digi;
/**
* La popup qui contient les données de l'évaluation complexe de digirisk
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluation_method
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>


<div class="popup" style="display: none;">
	<div class="container wp-digi-bloc-loader">
		<div class="header">
			<h2 class="title">Titre de la popup</h2>
			<i class="close fa fa-times"></i>
		</div>
			<div class="content" style="height: 60%">
				<textarea style="width: 100%; height: 100%; resize: none;"></textarea>
		</div>

		<button class="button button-primary"
						data-cb-object="DUER"
						data-cb-func="set_textarea_content">Ok</button>
		<button class="button button-secondary">Annuler</button>
	</div>

</div>
