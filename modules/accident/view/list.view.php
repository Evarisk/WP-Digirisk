<?php
/**
 * Affiches la liste des accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table accident">
	<div class="header">
		<span><?php esc_html_e( 'Ref.', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Nom, Prénom, matricule interne de la victime', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Date et heure', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Lieu', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'NB. jour arrêt', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Enquête accident', 'digirisk' ); ?></span>
	</div>

	<?php
	if ( ! empty( $accidents ) ) :
		foreach ( $accidents as $accident ) :
			\eoxia\View_Util::exec( 'digirisk', 'accident', 'list-item', array(
				'accident' => $accident,
			) );
		endforeach;
	endif;
	?>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'accident', 'item-add', array(
		'accident' => $accident_schema,
		'main_society' => $main_society,
	) );
	?>
</div>

<!-- flex table -->


<div class="flex-table accident">
	<div class="table-header">
		<div class="col">
			<div class="header-cell padding">Colonne 1</div>
			<div class="header-cell padding">Colonne 2</div>
			<div class="header-cell padding">Colonne 3</div>
			<div class="header-cell padding w100"></div>
		</div>
	</div>

	<div class="table-body">
		<div class="col">
			<div data-title="Colonne 1" class="cell padding">Contenu 1</div>
			<div data-title="Colonne 2" class="cell padding">Contenu 2</div>
			<div data-title="Colonne 3" class="cell padding">Contenu 3</div>
			<div data-title="action" class="cell w100">
				<div class="action grid-layout w3">
					<div 	class="button light w50 edit action-attribute"><i class="icon fa fa-pencil"></i></div>
					<div 	class="button light w50 delete action-delete"><i class="icon fa fa-times"></i></div>
				</div>
			</div>
		</div>

		<div class="col advanced">
			<div class="col">
				<div data-title="Colonne 1" class="cell padding">Contenu 1</div>
				<div data-title="Colonne 2" class="cell padding">Contenu 2</div>
				<div data-title="Colonne 3" class="cell padding">Contenu 3</div>
				<div data-title="action" class="cell w100">
					<div class="action grid-layout w3">
						<div data-parent="accident-row" data-loader="table" data-namespace="digirisk" data-module="accident" data-before-method="saveSignature" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
					</div>
				</div>
			</div>
			<div class="advanced">
				<form class="form">
					<div class="grid-layout padding w3">
						<div>
							<label for="champs1">Label</label>
							<input id="champs1" />
						</div>
						<div>
							<label for="champs2">Label</label>
							<input id="champs2" />
						</div>
						<div>
							<label for="champs3">Label</label>
							<input id="champs3" />
						</div>
					</div>
					<label for="textarea">Label</label>
					<textarea id="textarea">

					</textarea>
				</form>
			</div>
		</div>
	</div class="table-body">

	<div class="table-footer">
		<div class="col">
			<div class="cell" ></div>
			<div class="cell" ></div>
			<div class="cell" ></div>
			<div class="cell w100" data-title="action">
				<div class="action grid-layout w3">
					<div 	data-loader="table"
								data-parent="risk-row"
								class="button w50 blue add"><i class="icon fa fa-plus"></i></div>
				</div>
			</div>
		</div>
	</div class="table-footer">
</div>
