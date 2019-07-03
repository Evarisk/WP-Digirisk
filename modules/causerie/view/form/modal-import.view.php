<?php
/**
 * Boutton d'import d'une causerie.
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2019 Eoxia
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="digi-import-causeries-container" >
	<!-- Bouton d'ouverture de la modal pour l'import des causeries -->
	<a href="#" class="page-title-action wpeo-modal-event"
		data-title="<?php esc_html_e( 'Importer une causerie', 'digirisk' ); ?>"
		data-target="digi-import-causeries"
		data-parent="digi-import-causeries-container">
		<i class="fas fa-download" ></i>
		<?php esc_html_e( 'Importer une causerie', 'digirisk' ); ?>
	</a>

	<!-- Structure de la modal pour l'import de tâches -->
	<div class="wpeo-modal digi-import-causeries">
		<div class="modal-container">
			<div class="modal-header">
				<h2 class="modal-title"><?php echo esc_attr( 'Create tasks from text', 'task-manager' ); ?></h2>
				<div class="modal-close"><i class="fas fa-times"></i></div>
			</div>

			<div class="modal-content">
				<p>
					<?php
					Causerie_Class::g()->display_textarea();
				 	?>
			 	</p>
			</div>

			<div class="modal-footer">
				<div class="wpeo-button button-grey button-uppercase modal-close">
					<span><?php esc_html_e( 'Cancel', 'task-manager' ); ?></span>
				</div>
				<a class="wpeo-button button-main button-uppercase action-input"
					data-parent="digi-import-causeries"
					data-action="digi_import_causeries"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'digi_import_causeries' ) ); ?>" >
					<span><?php esc_html_e( 'Import', 'digirisk' ); ?></span>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="modal-info-error">

</div>
