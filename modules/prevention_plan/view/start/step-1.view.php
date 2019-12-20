<?php
/**
 * Premiere page dans la création d'un plan de prévention
 * Ajoute un formateur avec sa signature
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $eo_search; ?>

<?php
/**
 * Premiere page dans la création d'un plan de prévention
 * Ajoute un formateur avec sa signature
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

global $eo_search;

/**
 * Documentation des variables utilisées dans la vue.
 *
 * @var Society_Model    $society Les données de la société.
 * @var Permis_Feu_Model $prevention Les données du permis feu.
 */
?>

<div class="information-maitre-oeuvre wpeo-form" style="background-color: #fff; padding: 1em;">
	<h2 style="text-align:center">
		<?php esc_html_e( 'Maitre d\'oeuvre', 'digirisk' ); ?> -
		<i><?php echo esc_attr( $society->data['title'] ); ?></i>
		<span class="wpeo-tooltip-event"
		      aria-label="<?php esc_html_e( 'Responsable de la maitrise d\'ouvrage', 'digirisk' ); ?>"
		      style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>

	<div class="wpeo-gridlayout grid-4" style="align-items: end">
		<?php $eo_search->display( 'prevention_maitre_oeuvre' ); ?>

		<div class="form-element <?php echo ! empty( $prevention->data['maitre_oeuvre']['user_id'] ) ? 'form-element-disable' : ''; ?>">
			<span class="form-label"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input type="text" class="form-field" value="<?php echo ! empty( $prevention->data['maitre_oeuvre']['user_id'] ) ? $prevention->data['maitre_oeuvre']['data']->first_name : ''; ?>" />
			</label>
		</div>

		<div class="form-element <?php echo ! empty( $prevention->data['maitre_oeuvre']['user_id'] ) ? 'form-element-disable' : ''; ?>">
			<span class="form-label"><?php esc_html_e( 'Portable', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input type="text" class="form-field" value="<?php echo ! empty( $prevention->data['maitre_oeuvre']['user_id'] ) ? $prevention->data['maitre_oeuvre']['data']->phone : ''; ?>" />
			</label>
		</div>

		<div>
			<?php echo do_shortcode( '[digi_signature id="' . $prevention->data['id'] . '" key="maitre_oeuvre_signature_id"]' ); ?>
		</div>
	</div>
</div>
