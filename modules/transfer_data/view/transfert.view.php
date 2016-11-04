<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="about-wrap wp-digi-wrap wp-digi-clearer">
	<h1><?php _e( 'Transfert des données d\'Evarisk 5 vers DigiRisk 6', 'digirisk' ); ?></h1>
	<div class="about-text"><?php _e( 'La version 6 et ultérieur de DigiRisk vont utiliser les fonctionnalités de WordPress de manière plus avancée. Pour cela nous allons effectuer le transfert des données de votre version 5.X.X.X.', 'digirisk' ); ?></div>
	<?php wp_nonce_field('reset_method_evaluation'); ?>
	<h2 class="wp-digi-alert wp-digi-alert-error wp-digi-center" ><span class="wp-digi-bold" ><?php _e( 'Note importante : ', 'digirisk' ); ?></span><?php _e( 'Veillez a bien sauvegarder vos données avant de lancer le transfert des données', 'digirisk' ); ?></h2>

	<ul class="wp-digi-elements-to-transfer" >
	<?php
		$documents_to_transfer = $documents_transfered = $documents_not_transfered = 0;

		/**	Define if config components have to be transferd or not */
		if ( in_array( TABLE_GROUPEMENT, TransferData_class::g()->element_type) ) :
			$main_config_components_are_transfered = TransferData_components_class::g()->display_component_transfer_bloc();
		endif;

		/**	Read the different types	*/
		$element_to_treat = null;
		foreach ( TransferData_class::g()->element_type as $element_type ) :
			/**	Define element to treat by default with first array entry	*/
			$element_to_treat = empty( $element_to_treat ) ? $element_type : $element_to_treat;

			/**	Define the subelement type from main given	*/
			$sub_element_type = '';
			switch ( $element_type ) :
				case TABLE_TACHE:
					$main_element_name = __( 'Tâches', 'digirisk' );
					$sub_element_type = TABLE_ACTIVITE;
					$sub_element_name = __( 'Sous-tâches', 'digirisk' );
				break;

				case TABLE_GROUPEMENT:
					$main_element_name = __( 'Groupement', 'digirisk' );
					$sub_element_type = TABLE_UNITE_TRAVAIL;
					$sub_element_name = __( 'Unité de travail', 'digirisk' );
				break;
			endswitch;

			/**	Count the different eleent that have to be transfered	*/
			$element_to_transfert_count = TransferData_class::g()->get_transfer_progression( $element_type, $sub_element_type );
			$main_element_to_transfer = $element_to_transfert_count[ 'to_transfer' ]->main_element_nb;
			if ( ! empty( $element_to_transfert_count[ 'transfered' ][ $element_type ] ) && ! empty( $element_to_transfert_count['transfered'][ $element_type ]['state'] ) ) {
				unset( $element_to_transfert_count['transfered'][ $element_type ]['state'] );
			}
			$treated_tree_element = ' - ';
			if ( ! empty( $element_to_transfert_count[ 'transfered' ][ $element_type ] ) && ! empty( $element_to_transfert_count['transfered'][ $element_type ]['tree'] ) ) {
				$treated_tree_element = count( $element_to_transfert_count['transfered'][ $element_type ]['tree'] );
				unset( $element_to_transfert_count['transfered'][ $element_type ]['tree'] );
			}
				$main_element_transfered = !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ $element_type ]) ? count( $element_to_transfert_count[ 'transfered' ][ $element_type ] ) : 0;
			$sub_element_to_transfer = $element_to_transfert_count[ 'to_transfer' ]->sub_element_nb;
				$sub_element_transfered = !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ $sub_element_type ] ) ? count( $element_to_transfert_count[ 'transfered' ][ $sub_element_type ] ) : 0;
			$documents_to_transfer += $element_to_transfert_count[ 'to_transfer' ]->nb_picture + $element_to_transfert_count[ 'to_transfer' ]->nb_document + $element_to_transfert_count[ 'to_transfer' ]->nb_fiches + $element_to_transfert_count[ 'to_transfer' ]->nb_duer;

			/**		*/
			if ( ( $element_to_treat == $element_type ) && ( $main_element_transfered + $sub_element_transfered ) == ( $main_element_to_transfer + $sub_element_to_transfer ) ) {
				$element_to_treat = null;
			}

			/**	Increment document number transfered and not transfered due to error	*/
			$documents_transfered = 0;
			$documents_transfered += !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'picture' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'picture' ][ 'ok' ] ) ? count( $element_to_transfert_count[ 'transfered' ][ 'picture' ][ 'ok' ] ) : 0;
			$documents_transfered += !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'document' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'document' ][ 'ok' ] ) ? count( $element_to_transfert_count[ 'transfered' ][ 'document' ][ 'ok' ] ) : 0;
			$documents_transfered += !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'printed_duer' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'printed_duer' ][ 'ok' ] ) ? count( $element_to_transfert_count[ 'transfered' ][ 'printed_duer' ][ 'ok' ] ) : 0;
			$documents_transfered += !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'printed_sheet' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'printed_sheet' ][ 'ok' ] ) ? count( $element_to_transfert_count[ 'transfered' ][ 'printed_sheet' ][ 'ok' ] ) : 0;
			$documents_not_transfered = 0;
			$documents_not_transfered += !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'picture' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'picture' ][ 'nok' ] ) ? count( $element_to_transfert_count[ 'transfered' ][ 'picture' ][ 'nok' ] ) : 0;
			$documents_not_transfered += !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'document' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'document' ][ 'nok' ] ) ? count( $element_to_transfert_count[ 'transfered' ][ 'document' ][ 'nok' ] ) : 0;
			$documents_not_transfered += !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'printed_duer' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'printed_duer' ][ 'nok' ] ) ? count( $element_to_transfert_count[ 'transfered' ][ 'printed_duer' ][ 'nok' ] ) : 0;
			$documents_not_transfered += !empty( $element_to_transfert_count[ 'transfered' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'printed_sheet' ] ) && !empty( $element_to_transfert_count[ 'transfered' ][ 'printed_sheet' ][ 'nok' ] ) ? count( $element_to_transfert_count[ 'transfered' ][ 'printed_sheet' ][ 'nok' ] ) : 0;
		?>
		<li>
			<div class="wp-digi-datastransfer-element-type-name wp-digi-datastransfer-element-type-name-<?php echo $element_type; ?><?php if ( $main_element_to_transfer == $main_element_transfered ) : echo ' dashicons-before dashicons-yes'; endif; ?>" ><?php echo $main_element_name; ?></div>
			<ul class="wp-digi-datastransfer-element-type-detail" >
				<li><?php _e( 'Total', 'digirisk' ); ?> : <span class="wpdigi-to-transfer-element-nb-<?php echo $element_type; ?>" ><?php echo $main_element_to_transfer; ?></span></li>
				<li><?php _e( 'Transférés', 'digirisk' ); ?> : <span class="wpdigi-transfered-element-nb-<?php echo $element_type; ?>" ><?php echo $main_element_transfered; ?></span></li>
				<li><?php _e( 'Arborescence', 'digirisk' ); ?> : <span class="wpdigi-tree-check-<?php echo $element_type; ?>" ><?php esc_html_e( $treated_tree_element ); ?></span></li>
			</ul>
		</li>
		<li>
			<div class="wp-digi-datastransfer-element-type-name wp-digi-datastransfer-element-type-name-<?php echo $sub_element_type; ?><?php if ( $sub_element_to_transfer == $sub_element_transfered ) : echo ' dashicons-before dashicons-yes'; endif; ?>" ><?php echo $sub_element_name; ?></div>
			<ul class="wp-digi-datastransfer-element-type-detail" >
				<li><?php _e( 'Total', 'digirisk' ); ?> : <span class="wpdigi-to-transfer-element-nb-<?php echo $sub_element_type; ?>" ><?php echo $sub_element_to_transfer; ?></span></li>
				<li><?php _e( 'Transférés', 'digirisk' ); ?> : <span class="wpdigi-transfered-element-nb-<?php echo $sub_element_type; ?>" ><?php echo $sub_element_transfered; ?></span></li>
				<li>&nbsp;</li>
			</ul>
		</li>
	<?php endforeach; ?>

	<?php /**	Display	document transfer informations */	?>
		<li>
			<div class="wp-digi-datastransfer-element-type-name wp-digi-datastransfer-element-type-name-documents<?php if ( $documents_to_transfer == ( $documents_transfered + $documents_not_transfered ) ) : echo ' dashicons-before dashicons-yes'; endif; ?>" ><?php _e( 'Documents', 'digirisk' ); ?></div>
			<ul class="wp-digi-datastransfer-element-type-detail" >
				<li><?php _e( 'Total', 'digirisk' ); ?> : <span class="wpdigi-to-transfer-element-nb-documents" ><?php echo $documents_to_transfer; ?></span></li>
				<li><?php _e( 'Transférés', 'digirisk' ); ?> : <span class="wpdigi-transfered-element-nb-documents" ><?php echo $documents_transfered; ?></span></li>
				<li><?php _e( 'Non transférés', 'digirisk' ); ?> : <span class="wpdigi-not-transfered-element-nb-documents" ><?php echo $documents_not_transfered; ?></span></li>
			</ul>
		</li>
	</ul>
	<div class="wp-digi-alert wp-digi-alert-error wp-digi-center" id="wp-digi-transfert-message" ></div>
	<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" id="wpdigi-datastransfer-form" method="post" >
		<input type="hidden" name="action" value="wpdigi-datas-transfert<?php echo ( false === $main_config_components_are_transfered ) ? '-config_components' : ''; ?>" />
		<?php $current_type = ( false === $main_config_components_are_transfered ) ? 'config_components' : ( empty( $element_to_treat ) ? 'doc' : 'element' ); ?>
		<input type="hidden" name="sub_action" value="<?php echo $current_type; ?>" />
		<?php wp_nonce_field( 'wpdigi-datas-transfert' ); ?>
		<input type="hidden" name="element_type_to_transfert" value="<?php echo ( empty( $element_to_treat ) ? TransferData_class::g()->element_type[ 0 ] :  $element_to_treat ); ?>" />
		<input type="hidden" name="number_per_page" value="<?php echo DIGI_DTRANS_NB_ELMT_PER_PAGE; ?>" />

		<button class="wp-digi-bton wp-digi-bton-first alignright" ><?php _e( 'Démarrer le transfert', 'digirisk' ); ?></button>
	</form>

</div>
