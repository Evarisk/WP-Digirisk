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

	<div class="popup active">
		<div class="container">
			<div class="header">
				<h2 class="title">Titre de la popup</h2>
				<i class="close fa fa-times"></i>
			</div>
			<div class="content">
				<table class="table evaluation">
					<thead>
						<tr>
							<th></th><th>Gravité</th><th>Exposition</th><th>Occurence</th><th>Formation</th><th>Protection</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="padding">0</td>
							<td class="active">Pas de blessures possibles</td>
							<td>Jamais en contact</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>1</td>
							<td>Blessure légère</td>
							<td>Rare, 1 fois par an</td>
							<td>Jamais arrivé</td>
							<td>Prévention régulière</td>
							<td>Intrinsèque</td>
						</tr>
					</tbody>
				</table>
				<div class="button green margin uppercase strong float right"><span>Enregistrer la cotation</span></div>
			</div>
		</div>
	</div>

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
			<h1>Risques du groupement</h1>
			<table class="table">
				<thead>
					<tr>
						<th class="padding">Ref.</th>
						<th>Risque</th>
						<th>Quot.</th>
						<th>Photo</th>
						<th>Commentaire</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="padding">
							<span><strong>0412</strong></span>
						</td>
						<td>
							<div class="categorie-container toggle grid padding">
								<div class="action"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /><i class="icon animated fa fa-angle-down"></i></div>
							</div>
						</td>
						<td class="w50">
							<div class="cotation-container toggle grid">
								<div class="action cotation level1"><span>0</span></div>
							</div>
						</td>
						<td class="w50">
							<div class="media no-file">
								<i class="add animated fa fa-plus-circle"></i>
								<i class="default-image fa fa-picture-o"></i>
							</div>
						</td>
						<td class="full padding">
							<ul class="comment-container">
								<li class="comment">
									<span class="user">Jean Louis, </span>
									<span class="date">14/01/2017 : </span>
									<span class="content">Salut, c'est trop génial</span>
								</li>
							</ul>
						</td>
						<td>
							<div class="action grid-layout w3">
								<div class="button w50 task"><i class="icon dashicons dashicons-schedule"></i></div>
								<div class="button w50 edit"><i class="icon fa fa-pencil"></i></div>
								<div class="button w50 delete"><i class="icon fa fa-times"></i></div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="padding">
							<span><strong>0412</strong></span>
						</td>
						<td>
							<div class="categorie-container toggle grid padding">
								<div class="action"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /><i class="icon animated fa fa-angle-down"></i></div>
							</div>
						</td>
						<td class="w50">
							<div class="cotation-container toggle grid">
								<div class="action cotation level2"><span>48</span></div>
							</div>
						</td>
						<td class="w50">
							<div class="media no-file">
								<i class="add animated fa fa-plus-circle"></i>
								<i class="default-image fa fa-picture-o"></i>
							</div>
						</td>
						<td class="full padding">
							<ul class="comment-container">
								<li class="comment">
									<span class="user">Jean Louis, </span>
									<input type="text" class="date" value="03/01/2017" placeholder="03/01/2017" />
									<input type="text" class="content" value="Salut c'est trop génial" placeholder="Entrer un commentaire" />
									<span class="button delete"><i class="icon fa fa-times"></i></span>
								</li>
								<li class="comment">
									<span class="user">Jean Louis, </span>
									<input type="text" class="date" value="03/01/2017" placeholder="03/01/2017" />
									<input type="text" class="content" value="Salut c'est trop génial" placeholder="Entrer un commentaire" />
									<span class="button delete"><i class="icon fa fa-times"></i></span>
								</li>
								<li class="new comment">
									<span class="user">Jean Louis, </span>
									<input type="text" class="date" placeholder="03/01/2017" />
									<input type="text" class="content" placeholder="Entrer un commentaire" />
									<span class="button add"><i class="icon fa fa-plus"></i></span>
								</li>
							</ul>
						</td>
						<td>
							<div class="action grid-layout w3">
								<div class="button w50 green save"><i class="icon fa fa-floppy-o"></i></div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="padding">
							<span><strong>0412</strong></span>
						</td>
						<td>
							<div class="categorie-container toggle grid padding">
								<div class="action"><img src="https://www.eoxia.com/wp-content/uploads/2013/08/formations-web-2.jpg" /><i class="icon animated fa fa-angle-down"></i></div>
							</div>
						</td>
						<td class="w50">
							<div class="cotation-container toggle grid">
								<div class="action cotation level4"><span>80</span></div>
							</div>
						</td>
						<td class="w50">
							<div class="media no-file">
								<i class="add animated fa fa-plus-circle"></i>
								<i class="default-image fa fa-picture-o"></i>
							</div>
						</td>
						<td class="full padding">
							<ul class="comment-container">
								<li class="comment">
									<span class="user">Jean Louis, </span>
									<span class="date">14/01/2017 : </span>
									<span class="content">Salut, c'est trop génial</span>
								</li>
							</ul>
						</td>
						<td>
							<div class="action grid-layout w3">
								<div class="button w50 task"><i class="icon dashicons dashicons-schedule"></i></div>
								<div class="button w50 edit"><i class="icon fa fa-pencil"></i></div>
								<div class="button w50 delete"><i class="icon fa fa-times"></i></div>
							</div>
						</td>
					</tr>

				</tbody>

				<tfoot>
					<tr>
						<td class="padding"></td>
						<td class="wm130">
							<div class="categorie-container toggle grid padding">
								<div class="action"><span>Choisir un risque</span><i class="icon animated fa fa-angle-down"></i></div>
								<ul class="content">
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
									<li class="item"><img src="http://demo.digirisk.com/wp-content/uploads/2016/05/activitePhysique.png" /></li>
								</ul>
							</div>
						</td>
						<td class="w50">
							<div class="cotation-container toggle grid">
								<div class="action cotation default-cotation"><i class="icon fa fa-line-chart"></i></div>
								<ul class="content">
									<li class="item cotation level1"><span>0</span></li>
									<li class="item cotation level2"><span>48</span></li>
									<li class="item cotation level3"><span>51</span></li>
									<li class="item cotation level4"><span>80</span></li>
									<li class="item cotation method"><i class="icon fa fa-cog"></i></li>
								</ul>
							</div>
						</td>
						<td class="w50">
							<div class="media no-file">
								<i class="add animated fa fa-plus-circle"></i>
								<i class="default-image fa fa-picture-o"></i>
							</div>
						</td>
						<td class="full padding">
							<ul class="comment-container">
								<li class="new comment">
									<span class="user">Jean Louis, </span>
									<input type="text" class="date" placeholder="03/01/2017" />
									<input type="text" class="content" placeholder="Entrer un commentaire" />
								</li>
							</ul>
						</td>
						<td>
							<div class="action grid w1">
								<div class="button w50 blue add"><i class="icon fa fa-plus"></i></div>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>

			<h1>Evaluateurs</h1>
			<div class="grid-layout w2">
				<div>
					<label class="search">
						<i class="dashicons dashicons-search"></i>
						<input type="text" placeholder="Ecrivez votre recherche ici..." />
					</label>
					<table class="table">
						<thead>
							<tr>
								<th></th>
								<th class="padding">ID</th>
								<th class="padding">Nom</th>
								<th class="padding">Prénom</th>
								<th>Date d'embauche</th>
								<th><input type="text" class="affect" value="15" /></th>
								<th>Affecter</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><div class="avatar" style="background-color: #e05353;"><span>DD</span></div></td>
								<td class="padding"><span><strong>U16</strong></span></td>
								<td class="padding"><span>Dupont</span></td>
								<td class="padding"><span>Jean</span></td>
								<td><input type="text" value="04/01/2017" /></td>
								<td><input type="text" class="affect" value="" /></td>
								<td><input type="checkbox" /></td>
							</tr>
							<tr>
								<td><div class="avatar" style="background-color: #e9ad4f;"><span>GG</span></div></td>
								<td class="padding"><span><strong>U16</strong></span></td>
								<td class="padding"><span>Dupont</span></td>
								<td class="padding"><span>Jean</span></td>
								<td><input type="text" value="04/01/2017" /></td>
								<td><input type="text" class="affect" value="" /></td>
								<td><input type="checkbox" /></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div>
					<label class="search">
						<i class="dashicons dashicons-search"></i>
						<input type="text" placeholder="Ecrivez votre recherche ici..." />
					</label>
					<table class="table">
						<thead>
							<tr>
								<th></th>
								<th class="padding">ID</th>
								<th class="padding">Nom</th>
								<th class="padding">Prénom</th>
								<th>Date d'embauche</th>
								<th><input type="text" class="affect" value="15" /></th>
								<th>Affecter</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><div class="avatar" style="background-color: #e05353;"><span>DD</span></div></td>
								<td class="padding"><span><strong>U16</strong></span></td>
								<td class="padding"><span>Dupont</span></td>
								<td class="padding"><span>Jean</span></td>
								<td><input type="text" value="04/01/2017" /></td>
								<td><input type="text" class="affect" value="" /></td>
								<td><input type="checkbox" /></td>
							</tr>
							<tr>
								<td><div class="avatar" style="background-color: #e9ad4f;"><span>GG</span></div></td>
								<td class="padding"><span><strong>U16</strong></span></td>
								<td class="padding"><span>Dupont</span></td>
								<td class="padding"><span>Jean</span></td>
								<td><input type="text" value="04/01/2017" /></td>
								<td><input type="text" class="affect" value="" /></td>
								<td><input type="checkbox" /></td>
							</tr>
						</tbody>
					</table>
					<div class="button green uppercase strong float right margin"><span>Mettre à jour</span></div>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="digirisk-wrap" style="clear: both;">
	<?php do_shortcode( '[digi_navigation]' ); ?>
	<?php do_shortcode( '[digi_content]' ); ?>
</div>
