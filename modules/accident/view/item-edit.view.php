<?php
/**
 * Edition d'un accident
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.3.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $eo_search; ?>
<div class="table-row-advanced" data-id="<?php echo esc_attr( $accident->data['id'] ); ?>">
	<input type="hidden" name="action" value="edit_accident" />
	<?php wp_nonce_field( 'edit_accident' ); ?>
	<input type="hidden" name="accident[id]" value="<?php echo esc_attr( $accident->data['id'] ); ?>" />
	<input type="hidden" name="accident[parent_id]" value="<?php echo esc_attr( $accident->data['parent_id'] ); ?>" />

	<div class="table-row">
		<div data-title="Ref." class="table-cell table-150">
			<strong><?php echo esc_attr( $accident->data['unique_identifier'] ); ?></strong><br>
			<?php echo esc_attr( $accident->data['registration_date_in_register']['rendered']['date'] ); ?>
		</div>
		<div data-title="<?php esc_attr_e( 'Name., Surname.. victime', 'digirisk' ); ?>" class="table-cell table-150"><?php echo ! empty( $accident->data['victim_identity']->data['id'] ) ? User_Class::g()->element_prefix . $accident->data['victim_identity']->data['id'] . ' ' . $accident->data['victim_identity']->data['login'] : ''; ?></div>
		<div data-title="<?php esc_attr_e( 'Date & hour', 'digirisk' ); ?>" class="table-cell table-100"><?php echo esc_html( $accident->data['accident_date']['rendered']['date_time'] ); ?></div>
		<div data-title="<?php esc_attr_e( 'Place', 'digirisk' ); ?>" class="table-cell table-150"><?php echo esc_attr( $accident->data['place']->data['unique_identifier'] . ' ' . $accident->data['place']->data['title'] ); ?></div>
		<div data-title="<?php esc_attr_e( 'Circumstance', 'digirisk' ); ?>" class="table-cell"><?php do_shortcode( '[digi_comment id="' . $accident->data['id'] . '" namespace="eoxia" type="comment" display="view" display_date="false" display_user="false"]' ); ?></div>
		<div data-title="<?php esc_attr_e( 'Indicators', 'digirisk' ); ?>" class="table-cell table-75"><span class="number-field"><?php echo esc_attr( $accident->data['number_field_completed'] ); ?></span>/13</div>
		<div data-title="<?php esc_attr_e( 'Actions', 'digirisk' ); ?>" class="table-cell table-150 table-end">
			<div class="action">
				<div data-parent="table-row-advanced[data-id='<?php echo esc_attr( $accident->data['id'] ); ?>']" data-loader="table-flex" data-namespace="digirisk" data-module="accident" data-before-method="checkAllData" class="wpeo-button button-square-50 button-green save action-input"><i class="button-icon fas fa-save"></i></div>
			</div>
		</div>
	</div>

	<div class="advanced">
		<div class="wpeo-form">
			<div class="wpeo-gridlayout grid-3">
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Name., Surname.. victime', 'digirisk' ); ?></span>
					<div class="form-field-container">
						<?php $eo_search->display( 'accident_user' ); ?>
					</div>
				</div>

				<div class="form-element group-date">
					<span class="form-label"><?php esc_html_e( 'Date & hour', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="far fa-calendar-alt"></i></span>
						<input type="hidden" class="mysql-date" name="accident[accident_date]" value="<?php echo esc_attr( $accident->data['accident_date']['raw'] ); ?>" />
						<input type="text" class="form-field date" value="<?php echo esc_html( $accident->data['accident_date']['rendered']['date_time'] ); ?>" />
					</label>
				</div>

				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Lieu', 'digirisk' ); ?></span>
					<div class="form-field-container">
						<?php $eo_search->display( 'accident_post' ); ?>
					</div>
				</div>
			</div>
			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Detailed circumstances', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<?php do_shortcode( '[digi_comment id="' . $accident->data['id'] . '" namespace="eoxia" type="comment" display="edit" display_date="false" display_user="false"]' ); ?>
				</label>
			</div>

			<div class="wpeo-gridlayout grid-2">
				<?php
				\eoxia\View_Util::exec( 'digirisk', 'accident', 'list-stopping-day', array(
					'accident' => $accident,
				) );
				?>
				<div class="work-stopping-communication">
					<div class="form-element">
						<span class="form-label">
							<?php esc_html_e( 'Add a Work Stopping Communication', 'digirisk' ); ?>
						</span>
						<?php if (! empty( $accident->data['work_stopping_communication'] )): ?>
							<span class="content"> <?php echo "Lien vers votre déclaration d'arrêt de travail : ";?>
								<div class="wpeo-button button-blue button-square-30 goto-work-stopping-communication-link" >
									<a href="<?php echo ( $accident->data['work_stopping_communication'] );?>" target="_blank"><i class="button-icon fas fa-external-link-alt" style="color:#FFFFFF" ></i></a>
								</div>
								<div class="wpeo-button button-grey button-square-30 edit-work-stopping-communication-link" data-action="editAccidentWorkStoppingCommunication">
										<i class="button-icon fas fa-pencil-alt" ></i>
								</div>
							</span>
						<?php else : ?>
							<span class="content">
								<?php echo "Renseignez un lien vers votre déclaration d'arrêt de travail : ";?>
							</span>
						<?php endif ; ?>
							<ul class="comment-container">
								<li class="comment tooltip red">
									<div class="work-stop-field form-element">
										<label class="form-field-container">
										<?php if ( empty( $accident->data['work_stopping_communication'] )): ?>
											<span class="form-field-icon-prev"><i class="fas fa-book-reader" ></i></span>
											<input type="text" placeholder="https:// ..." class="form-field" id="work_stopping_communication" name="accident[work_stopping_communication]" value="<?php echo ( $accident->data['work_stopping_communication'] ); ?>">
										<?php else : ?>
											<span class="form-field-icon-prev work-stop hidden"><i class="fas fa-book-reader" ></i></span>
											<input class="form-field work-stop hidden" placeholder="https:// ..." id="work_stopping_communication" name="accident[work_stopping_communication]" value="<?php echo ( $accident->data['work_stopping_communication'] ); ?>">
										<?php endif ; ?>
										</label>
									</div>
								</li>
							</ul>
					</div>
				</div>
			</div>

			<div class="investigation-group">
				<div class="form-element">
						<span class="form-label"><?php esc_html_e( 'Accident investigation', 'digirisk' ); ?></span>
						<label class="form-field-container">
							<div class="form-field-inline">
								<input id="have_investigation" class="form-field" type="checkbox" <?php echo $accident->data['have_investigation'] ? 'checked' : ''; ?> name="accident[have_investigation]" />
								<label for="have_investigation"><?php esc_html_e( 'Carry out an accident investigation', 'digirisk' ); ?></label>
							</div>
						</label>
					</div>

					<div class="investigation-media <?php echo ( ! $accident->data['have_investigation'] ) ? 'hidden' : ''; ?>">
						<?php echo do_shortcode( '[wpeo_upload id="' . $accident->data['id'] . '" model_name="/digi/Accident_Class" single="true" mime_type="application" field_name="accident_investigation_id" custom_class="investigation" title="' . $accident->data['unique_identifier'] . ' : ' . __( 'enquête accident', 'digirisk' ) . '"]' ); ?>
					</div>
				</div>
			</div>

			<div class="wpeo-gridlayout grid-2">
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Seat lesions (specify right or left)', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<input type="text" class="form-field" id="location_of_lesions" name="accident[location_of_lesions]" value="<?php echo esc_attr( $accident->data['location_of_lesions'] ); ?>">
					</label>
				</div>

				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Nature of lesions', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<input class="form-field" type="text" id="nature_of_lesions" name="accident[nature_of_lesions]" value="<?php echo esc_attr( $accident->data['nature_of_lesions'] ); ?>">
					</label>
				</div>
			</div>

			<div class="wpeo-gridlayout grid-2">
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Name and address of witnesses', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<textarea class="form-field" id="name_witnesses" name="accident[name_and_address_of_witnesses]"><?php echo $accident->data['name_and_address_of_witnesses']; ?></textarea>
					</label>
				</div>

				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Name and address of third parties involved', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<textarea class="form-field" id="name_and_address_of_third_parties_involved" name="accident[name_and_address_of_third_parties_involved]"><?php echo $accident->data['name_and_address_of_third_parties_involved']; ?></textarea>
					</label>
				</div>
			</div>

			<div class="wpeo-gridlayout grid-2">
				<div class="form-element">
					<?php echo do_shortcode( '[digi_signature title="' . __( 'Signature du soignant', 'digirisk' ) . '" key="signature_of_the_caregiver_id" id="' . $accident->data['id'] . '"]' ); ?>
				</div>
				<div class="form-element">
					<?php echo do_shortcode( '[digi_signature title="' . __( 'Signature de la victime', 'digirisk' ) . '" key="signature_of_the_victim_id" id="' . $accident->data['id'] . '"]' ); ?>
				</div>
			</div>

			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Note', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<textarea class="form-field" id="observation" name="accident[observation]"><?php echo $accident->data['observation']; ?></textarea>
				</label>
			</div>

			<div class="table-action">
				<div data-parent="table-row-advanced[data-id='<?php echo esc_attr( $accident->data['id'] ); ?>']" data-loader="table-flex" data-namespace="digirisk" data-module="accident" data-before-method="checkAllData" class="wpeo-button button-square-50 button-green save action-input"><i class="button-icon fas fa-save"></i></div>
			</div>
		</div>
	</div>
</div>
