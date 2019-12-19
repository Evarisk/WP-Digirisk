<?php
/**
 * Vue principale de l'application
 * Exécutes deux shortcodes:
 *
 * [digi_navigation] pour afficher la navigation entre les différentes sociétés créées dans DigiRisk.
 * [digi_application] pour afficher l'application DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>


<div class="digirisk-wrap wpeo-wrap wpeo-box" style="clear: both;">
	<?php
		if ( ! empty( $waiting_updates ) && strpos( $_SERVER['REQUEST_URI'], 'admin.php' ) && ! strpos( $_SERVER['REQUEST_URI'], 'admin.php?page=' . \eoxia\Config_Util::$init['digirisk']->update_page_url ) ) :
			\eoxia\Update_Manager_Class::g()->display_say_to_update( 'digirisk', __( 'Need to update DigiRisk data', 'digirisk' ) );
		endif;
	?>
	<h2>GÉREZ VOTRE DOCUMENT UNIQUE, AFFICHAGE LÉGAL, ET BIEN PLUS...</h2>

	<div class="wpeo-gridlayout grid-3 top-content">
		<div>
			<div><img src="https://www.digirisk.com/wp-content/uploads/2017/11/ressources-humaines.png" /></div>
			<h3>GESTION DES RISQUES</h3>
			<p>Les risques sont traités comme suit :<br />
				Selon la société et/ou groupement<br />
				Selon unité de travail<br />
				Selon photo<br />
			</p>
		</div>

		<div>
			<div><img src="https://www.digirisk.com/wp-content/uploads/2017/11/document-unique.png" /></div>
			<h3>DOCUMENT UNIQUE</h3>
			<p>Impression en un clic de votre Document Unique<br />
				Personnalisation des fiches de poste<br />
				Impression des fiches de poste<br />
				Export natif au format Open Office<br />
				Personnalisable facilement avec Open Office
			</p>
		</div>

		<div>
			<div><img src="https://www.digirisk.com/wp-content/uploads/2017/11/gestion-des-risques.png" /></div>
			<h3>GESTION AFFICHAGE LÉGAL</h3>
			<p>Impression de l'affichage légal<br />Impression des fiches de postes
			</p>
		</div>
	</div>

	<?php
	if ( $ask_auto_connect ) :
		?>
		<div class="wpeo-modal modal-active modal-interface">
			<div class="modal-container">

				<!-- Entête -->
				<div class="modal-header">
					<h2 class="modal-title">Interface par défaut</h2>
					<div class="modal-close"><i class="fas fa-times"></i></div>
				</div>

				<!-- Corps -->
				<div class="modal-content">
					<p>DigiRisk n'est pas votre interface par défaut. Voulez-vous la définir en tant qu'interface par défaut ?</p>
					<div class="wpeo-form">
						<div class="form-element">
							<div class="form-field-inline">
								<input type="checkbox" id="no-ask-again" class="form-field" checked="checked" name="ask_again" />
								<label for="no-ask-again">Toujours effectuer cette vérification au démarrage de DigiRisk.</label>
							</div>
						</div>
					</div>
				</div>

				<!-- Footer -->
				<div class="modal-footer">
					<a class="action-input wpeo-button button-main button-uppercase"
						data-parent="wpeo-modal"
					   data-set-default="true"
					   data-action="set_default_app"><span>Faire de DigiRisk mon interface par défaut.</span></a>
					<a class="action-input wpeo-button button-grey button-uppercase"
						data-parent="wpeo-modal"
					   	data-set-default="false"
						data-action="set_default_app"><span>Plus tard</span></a>
				</div>
			</div>
		</div>
		<?php
		endif;
	?>
</div>
