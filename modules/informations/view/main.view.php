<?php
/**
 * Template pour les informations de la société.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.2.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<?php if ( ( $type != 'digi-group' ) && ( $type != 'digi-workunit' ) ) : ?>
    <h3><?php esc_html_e( 'Document unique', 'digirisk' ); ?></h3>

    <div class="wpeo-gridlayout grid-3">
        <p>
            <span><?php esc_html_e( 'Date dernière impression:', 'digirisk' ); ?></span>
            <span><strong><?php echo ( ! empty( $current_duer ) ) ? $current_duer->data['date']['rendered']['date'] : __( 'N/A', 'digirisk' ); ?></strong></span>
        </p>
        <p><?php printf( __( 'Mise à jour obligatoire tous les <strong>%d</strong> jours', 'digirisk' ), $general_options['required_duer_day'] ); ?></p>
        <p><?php printf( __( 'Nombre de jours restant avant la prochaine mise à jour obligatoire: <strong>%s</strong> jours', 'digirisk' ), ! empty( $date_before_next_duer ) ? $date_before_next_duer : 'N/A' ); ?></p>
    </div>

    <h3><?php esc_html_e( 'Accident', 'digirisk' ); ?></h3>

    <div class="wpeo-gridlayout grid-3">
        <p>
            <span><?php esc_html_e( 'Date du dernier accident:', 'digirisk' ); ?></span>

            <span><strong><?php echo ( ! empty( $accident ) ) ? $accident->data['accident_date']['rendered']['date'] : __( 'N/A', 'digirisk' ); ?></strong></span>
        </p>

        <p>
            <span><?php esc_html_e( 'Nombre de jour sans accident:', 'digirisk' ); ?></span>

            <span><strong><?php echo isset($days_without_accident) ? $days_without_accident : __( 'N/A', 'digirisk' ); ?></strong></span>
        </p>
        <p><?php printf( __( 'Unité de Travail concernée: <strong>%s</strong>', 'digirisk' ), ! empty( $accident ) ? $accident->data['place']->data['unique_identifier'] . ' - ' . $accident->data['place']->data['title'] : 'N/A' ); ?></p>
    </div>
<?php endif; ?>

<h3><?php esc_html_e ('Description de la société' , 'digirisk') ;?></h3>

<?php $society = Society_Class::g()->show_by_type(9) ?>

<div class="society-description">
    <textarea type="text" style="width: 100% !important;" value="<?php printf($society->data['content']);?>" name="societyDescription"><?php printf($society->data['content']);?></textarea>
    <input type="hidden" name="idSociety" value="<?php echo $society->data['id'] ;?>">
    <input type="hidden" name="action" value="save_society_description">

    <div class="wpeo-button button-green button-square-50 action-input save active"
         data-parent="society-description">
        <i class="button-icon fas fa-save"></i>
    </div>

</div>

<h3><?php esc_html_e( 'Analyse par unité de travail ou GP', 'digirisk' ); ?> </h3>

<div class="wpeo-gridlayout grid-3">
    <p>
        <span><?php esc_html_e( 'Date de l\'action:', 'digirisk' ); ?></span>
        <span><strong><?php echo ( ! empty( $historic_update ) && isset( $historic_update['date']['date'] ) ) ? $historic_update['date']['date'] : 'N/A'; ?></strong></span>
    </p>
    <p><?php printf( __( 'UT ou GP: <strong>%s</strong>', 'digirisk' ), ( ! empty( $historic_update['parent_id'] ) ) ? $historic_update['parent']->data['unique_identifier'] . ' - ' . $historic_update['parent']->data['title'] : 'N/A' ); ?></p>
    <p><?php printf( __( 'Description de l\'action: <strong>%s</strong>', 'digirisk' ), ! empty( $historic_update ) ? $historic_update['content'] : 'N/A' ); ?></p>
</div>

<h3><?php _e( 'Analyse par personne', 'digirisk' ); ?></h3>

<div class="wpeo-gridlayout grid-3">
    <p>
        <span><?php _e( 'Nombre de personnes sur l\'établissement:', 'digirisk' ); ?></span>
        <span><strong><?php echo esc_html( $total_users ); ?></strong></span>
    </p>
    <p><?php printf( __( 'Nombre de personnes impliqués: <strong>%s évaluateur(s)</strong>', 'digirisk' ), $number_evaluator ); ?></p>
    <p><?php printf( __( 'Pourcentage: <strong>%s</strong>', 'digirisk' ), $average ); ?></p>
</div>

<div class="section-risk"></div>
