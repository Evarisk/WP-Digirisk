<?php
/**
 * La popup qui contient les historiques des documents.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.3.0
 * @copyright 2015-2016 Eoxia
 * @package handle_model
 * @subpackage view
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; } ?>


<div class="popup">
	<div class="container wp-digi-bloc-loader">
		<div class="header">
			<h2 class="title">Historique des modèles</h2>
			<i class="close fa fa-times"></i>
		</div>
		<div class="content">
			<img src="<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>" alt="<?php echo esc_attr( 'Chargement...' ); ?>" />
		</div>

		<button class="button button-secondary">OK</button>
	</div>

</div>
