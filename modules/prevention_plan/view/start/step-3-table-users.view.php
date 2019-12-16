<?php
/**
 * Etape du liste des intervenants
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

 <div class="wpeo-table table-flex table-4">
 	<div class="table-row table-header">
 		<div class="table-cell" style="text-align : center"><?php esc_html_e( 'Nom', 'task-manager' ); ?></div>
 		<div class="table-cell" style="text-align : center"><?php esc_html_e( 'Prenom', 'task-manager' ); ?></div>
		<div class="table-cell" style="text-align : center"><?php esc_html_e( 'Email', 'task-manager' ); ?></div>
		<div class="table-cell" style="text-align : center"><?php esc_html_e( 'Phone', 'task-manager' ); ?></div>
 		<div class="table-cell" style="text-align : center"></div>
 	</div>

	<?php if( ! empty( $prevention->data[ 'intervenants' ] ) ):
		foreach( $prevention->data[ 'intervenants' ] as $key => $user ): ?>
		<div class="table-row table-row-intervenant">
	 		<div class="table-cell">
	 			<div class="wpeo-form">
	 				<div class="form-element">
	 					<label class="form-field-container">
	 						<span><?php echo esc_attr( $user[ 'name' ] ); ?></span>
	 					</label>
	 				</div>
	 			</div>
	 		</div>
	 		<div class="table-cell">
	 			<div class="wpeo-form">
	 				<div class="form-element">
	 					<label class="form-field-container">
							<span><?php echo esc_attr( $user[ 'lastname' ] ); ?></span>
	 					</label>
	 				</div>
	 			</div>
	 		</div>
	 		<div class="table-cell">
	 			<div class="wpeo-form">
	 				<div class="form-element">
	 					<label class="form-field-container">
							<span><?php echo esc_attr( $user[ 'mail' ] ); ?></span>
	 					</label>
	 				</div>
	 			</div>
	 		</div>
			<div class="table-cell">
				<div class="wpeo-form">
					<div class="form-element">
						<label class="form-field-container">
							<span>
								<?php if( isset( $user[ 'phone' ] ) ): ?>
									<?php echo esc_attr( '(' . $user['phone_callingcode'] . ')' . $user[ 'phone' ] ); ?>
								<?php else: ?>
									-
								<?php endif; ?>
							</span>
						</label>
					</div>
				</div>
			</div>

	 		<div class="table-cell table-end">
	 			<div class="wpeo-button button-main button-bordered action-attribute"
	 				data-key="<?php echo esc_attr( $key ); ?>"
					data-id="<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>"
					data-action="<?php echo esc_attr( 'edit_intervenant_prevention' ); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_intervenant_prevention' ) ); ?>">
	 				<i class="fas fa-pen" style="color : white"></i>
	 			</div>
	 		</div>
	 	</div>

	<?php endforeach;
	endif; ?>

 	<div class="table-row table-new-line-intervenant" style="display : none">
 		<div class="table-cell update-mail-auto">
 			<div class="wpeo-form">
 				<div class="form-element">
 					<label class="form-field-container">
 						<input type="text" name="name" class="form-field">
 					</label>
 				</div>
 			</div>
 		</div>
 		<div class="table-cell update-mail-auto">
 			<div class="wpeo-form">
 				<div class="form-element">
 					<label class="form-field-container">
 						<input type="text" name="lastname" class="form-field">
 					</label>
 				</div>
 			</div>
 		</div>
 		<div class="table-cell">
 			<div class="wpeo-form">
 				<div class="form-element">
 					<label class="form-field-container">
 						<input type="text" name="mail" class="form-field">
 					</label>
 				</div>
 			</div>
 		</div>
		<div class="table-cell">
			<div class="wpeo-form phone-bloc digi-phone-user">
				<div class="form-element">
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-mobile-alt"></i></span>
						<input type="text" class="form-field element-phone-input" name="phone" value="" style="width: auto;">
					</label>
				</div>
			</div>
		</div>

 		<div class="table-cell table-end">
 			<div class="wpeo-button button-main button-bordered action-input"
				data-id="<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>"
 				data-parent="table-row"
				data-action="add_intervenant_to_prevention"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'add_intervenant_to_prevention' ) ); ?>">
 				<i class="fas fa-plus" style="color: white;"></i>
 			</div>
 		</div>
 	</div>
 </div>
