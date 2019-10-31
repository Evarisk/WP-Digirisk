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

<div class="content-wrap">
	<?php Digirisk::g()->display_header(); ?>

	<div class="digirisk-wrap wpeo-wrap" style="clear: both;">

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
	</div>
</div>
