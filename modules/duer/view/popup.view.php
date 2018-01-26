<?php
/**
 * La popup qui contient les formulaires ainsi que les informations de la génération du DUER.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="popup">
	<div class="container">

		<div class="header">
			<h2 class="title">Titre de la popup</h2>
			<i class="close fa fa-times"></i>
		</div>

		<div class="content">
			<div class="change-content">
				<img src='<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>' alt='<?php echo esc_attr( 'Chargement...' ); ?>' />
			</div>

			<div 	data-cb-namespace="digirisk"
						data-cb-object="DUER"
						data-cb-func="set_textarea_content"
						class="button green margin uppercase strong float right"><span>OK</span></div>
		</div>
	</div>
</div>
