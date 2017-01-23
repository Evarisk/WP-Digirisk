<?php
/**
 * Vue principale de l'application
 * Utilises deux shortcodes
 * digi_navigation: Pour la navigation dans les groupements et les unités de travail
 * digi_content: Pour le contenu de l'application
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="digirisk-wrap" style="clear: both;">

	<div class="navigation-container">
	<div class="workunit-navigation">
		<div class="unit-header">
			<span class="media">
				<span class="add animated fa fa-plus-circle"></span>
				<img src="https://www.eoxia.com/wp-content/uploads/2013/08/formations-web-2.jpg" />
			</span>
			<span class="title"><strong>UT2 - </strong>Titre 2</span>
			<span class="toggle button w50"><i class="icon fa fa-angle-down"></i></span>
		</div>
		<!--<ul class="content active">
			<li class="item active">
				<span class="title">GP4 - Truc machin</span>
				<span class="add button w40"><i class="icon fa fa-plus"></i></span>
				<ul class="sub-menu">
					<li class="item active">
						<span class="title">GP4 - Truc machin</span>
						<span class="add button w40"><i class="icon fa fa-plus"></i></span>
					</li>
					<li class="item active">
						<span class="title">GP4 - Truc machin</span>
						<span class="add button w40"><i class="icon fa fa-plus"></i></span>
					</li>
				</ul>
			</li>
			<li class="item">
				<span class="title">GP5 - Truc machin</span>
				<span class="add button w40"><i class="icon fa fa-plus"></i></span>
			</li>
		</ul>-->
	</div>

		<ul class="workunit-list">
			<li class="unit-header">
				<span class="media no-file">
					<span class="add animated fa fa-plus-circle"></span>
					<i class="default-image fa fa-picture-o"></i>
				</span>
				<span class="title"><strong>UT1 - </strong>Titre 1</span>
				<span class="delete button w50"><i class="icon dashicons dashicons-no-alt"></i></span>
			</li>
			<li class="unit-header">
				<span class="media">
					<span class="add animated fa fa-plus-circle"></span>
					<img src="https://www.eoxia.com/wp-content/uploads/2013/08/formations-web-2.jpg" />
				</span>
				<span class="title"><strong>UT2 - </strong>Titre 2</span>
				<span class="delete button w50"><i class="icon dashicons dashicons-no-alt"></i></span>
			</li>
		</ul>

		<div class="workunit-add">
			<input type="text" placeholder="Ma nouvelle unité de travail" class="title" />
			<div class="add blue button w50"><i class="icon fa fa-plus"></i></div>
		</div>
	</div>

	<div class="main-container">
		<div class="main-header">
			<div class="unit-header">
				<div class="media no-file">
					<i class="add animated fa fa-plus-circle"></i>
					<i class="default-image fa fa-picture-o"></i>
				</div>
				<span class="title"><strong>UT1 - </strong>Titre 1</span>
			</div>
			<div class="dut button red uppercase"><i class="icon fa fa-download"></i><span>Télécharger le document unique</span></div>
		</div>

		<ul class="tab">
			<li class="tab-element active">Risques</li>
			<li class="tab-element">Utilisateurs</li>
			<li class="tab-element">Evaluateurs</li>
			<li class="tab-element">Produits chimiques</li>
			<li class="tab-element">Epi</li>
			<li class="tab-element toggle option">
				<i class="action fa fa-ellipsis-v"></i>
				<ul class="content">
					<li class="item">Configuration groupement</li>
					<li class="item">Interface avancée</li>
					<li class="item">Supprimer groupement</li>
				</ul>
			</li>
			<li class="gp button red"><i class="icon fa fa-download"></i><span>Fiche de groupement</span></li>
		</ul>

		<div class="main-content">
			<h1>Affichage légal</h1>

			<form class="form grid-layout w2">
				<div>
					<h2>Inspection du travail</h2>
					<div class="form-element">
						<input type="text" />
						<label>Nom de l'inspecteur</label>
						<span class="bar"></span>
					</div>
					<div class="form-element">
						<input type="text" />
						<label>Adresse</label>
						<span class="bar"></span>
					</div>
				</div>
				<div>
					<h2>Service de santé du travail</h2>
					<div class="form-element">
						<input type="text" />
						<label>Nom du médecin de travail</label>
						<span class="bar"></span>
					</div>
				</div>
			</form>

		</div>
	</div>

</div>

<div class="digirisk-wrap" style="clear: both;">
	<?php do_shortcode( '[digi_navigation]' ); ?>
	<?php do_shortcode( '[digi_content]' ); ?>
</div>
