<?php
/**
 * La popup qui contient les données de l'évaluation complexe de digirisk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package evaluation_method
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="popup popup-evaluation">
	<div class="container">
		<div class="header">
			<h2 class="title"><?php echo esc_html_e( 'Édition de la méthode d\'évaluation Evarisk', 'digirisk' ); ?></h2>
			<i class="close fa fa-times"></i>
		</div>
		<div class="content">

			<input type="hidden" class="digi-method-evaluation-id" value="<?php echo esc_attr( ! empty( $term_evarisk->term_id ) ? $term_evarisk->term_id : 0 ); ?>" />

			<table class="table evaluation">
				<thead>
					<tr>
						<td></td>
						<?php View_Util::exec( 'evaluation_method', 'popup/header', array( 'list_evaluation_method_variable' => $list_evaluation_method_variable ) ); ?>
					</tr>
				</thead>
				<tbody>
					<?php for ( $i = 0; $i < count( $list_evaluation_method_variable ); $i++ ) :
						View_Util::exec( 'evaluation_method', 'popup/row', array( 'i' => $i, 'list_evaluation_method_variable' => $list_evaluation_method_variable ) );
					endfor; ?>
				</tbody>
			</table>
			<div data-nonce="<?php echo esc_attr( wp_create_nonce( 'get_scale' ) ); ?>" class="button green margin uppercase strong float right"><span>Enregistrer la cotation</span></div>
		</div>
	</div>
</div>
