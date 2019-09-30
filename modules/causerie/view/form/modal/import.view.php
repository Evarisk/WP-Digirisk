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
<div class="digi-import-causeries-container">
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
		<div class="modal-container" style="width: 80%; height: 80%; max-height: none; max-width: none">
			<div class="modal-header">
				<h2 class="modal-title"><?php echo esc_attr( 'Create tasks from text', 'task-manager' ); ?></h2>
				<div class="modal-close"><i class="fas fa-times"></i></div>
			</div>

			<div class="modal-content">
				<div class="digi-view-textarea">
					<?php
						Causerie_Class::g()->display_textarea();
				 	?>
			 	</div>
			</div>

			<div class="modal-footer">
				<div class="modal-footer-view-textarea">
					<?php
						\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/modal/footer', array() );
					?>
				</div>
				<div class="modal-footer-view-git view-git-element" style="display : none">
					<?php
						// \eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/modal-footer-git', array() );
					?>
				</div>
				<div class="digi-view-execute digi-footer-execute" style="display : none">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal-info-error">

</div>
