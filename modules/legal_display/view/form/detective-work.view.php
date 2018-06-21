<?php
/**
 * Inspecteur du travail
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.0.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="form">
	<li><h2><?php esc_html_e( 'Inspection du travail', 'digirisk' ); ?></h2></li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['detective_work']->data['full_name'] ) ? 'active' : '' ); ?>">
		<input name="detective_work[full_name]" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['full_name'] ); ?>" />
		<label><?php esc_html_e( 'Nom de l\'inspecteur', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['detective_work']->data['address']->data['address'] ) ? 'active' : '' ); ?>">
		<input name="detective_work[address][address]" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['address']->data['address'] ); ?>" />
		<label><?php esc_html_e( 'Adresse', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['detective_work']->data['address']->data['postcode'] ) ? 'active' : '' ); ?>">
		<input name="detective_work[address][postcode]" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['address']->data['postcode'] ); ?>" />
		<label><?php esc_html_e( 'Code postal', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['detective_work']->data['address']->data['town'] ) ? 'active' : '' ); ?>">
		<input name="detective_work[address][town]" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['address']->data['town'] ); ?>" />
		<label><?php esc_html_e( 'Ville', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['detective_work']->data['contact']['phone'] ) ? 'active' : '' ); ?>">
		<input name="detective_work[contact][phone]" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['contact']['phone'] ); ?>" />
		<label><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['detective_work']->data['opening_time'] ) ? 'active' : '' ); ?>">
		<input name="detective_work[opening_time]" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['opening_time'] ); ?>"/>
		<label><?php esc_html_e( 'Horaires', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
