<?php
/**
 * Affiches la liste des causeries
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap digirisk-wrap">
	<div>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>"><?php esc_html_e( 'Retour', 'digirisk' ); ?></a>

		<h2><?php esc_html_e( 'Causerie en cours', 'digirisk' ); ?></h2>

		<div class="step install">
			<ul class="step-list">
				<li class="step active"><span class="title"><?php esc_html_e( 'Signature du formateur', 'digirisk' ); ?></span></li>
				<li class="step" data-width="50"><span class="title"><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span></li>
				<li class="step" data-width="100"><span class="title"><?php esc_html_e( 'Enregistrement des participants', 'digirisk' ); ?></span></li>
			</ul>
			<div class="bar">
				<div class="background"></div>
				<div class="loader" data-width="0"></div>
			</div>
		</div>

		<div class="main-content">
			<p>
				<span><?php echo esc_html( $final_causerie->title ); ?></span>
				<span><?php echo esc_html( $final_causerie->risk_category->name ); ?></span>
			</p>

			<p><?php echo esc_html( $final_causerie->content ); ?></p>

			<ul>
				<li><?php esc_html_e( sprintf( 'Cette causerie à été réalisée %d fois', $main_causerie->number_time_realized ), 'digirisk' ); ?></li>
				<li><?php esc_html_e( sprintf( '%d personnes y ont déjà participés', $main_causerie->number_participants ), 'digirisk' ); ?></li>
				<li>
						<span><?php esc_html_e( 'Réalisée pour la dernière fois le', 'digirisk' ); ?></span>
						<span>
							<?php if ( $main_causerie->number_time_realized > 0 ) : ?>
								<?php esc_html( $main_causerie->last_date_realized['date_human_readable'] ); ?>
							<?php else : ?>
								<?php esc_html_e( 'NA', 'digirisk' ); ?>
							<?php endif; ?>
						</span>
					</li>
			</ul>

			<p><?php esc_html_e( 'Formateur', 'digirisk' ); ?></p>

			<table class="table causerie">
				<thead>
					<tr>
						<th class="w50 padding"><?php esc_html_e( 'Formateur', 'digirisk' ); ?>.</th>
						<th class="w50 padding"><?php esc_html_e( 'Signature', 'digirisk' ); ?>.</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td class="w50 padding">
							<input type="text"
										data-field="former_id"
										data-type="user"
										placeholder=""
										class="digi-search"
										value="" />
							<input type="hidden" name="former_id" value="" />
						</td>
						<td class="w50 padding">
							<div class="wpeo-button button-blue wpeo-modal-event" data-class="modal-signature" data-action="load_modal_signature" data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_modal_signature' ) ); ?>">
								<span><?php esc_html_e( 'Signé', 'digirisk' ); ?></span>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
	</div>

		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>" class="wpeo-button button-grey">
			<span><?php esc_html_e( 'Retour', 'digirisk' ); ?></span>
		</a>

		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie&id=' . $final_causerie->id . '&step=2' ) ); ?>" class="wpeo-button button-main">
			<span><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span>
		</a>
	</div>
</div>
