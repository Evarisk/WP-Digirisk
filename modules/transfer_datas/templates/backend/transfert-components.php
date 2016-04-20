<?php if ( !defined( 'ABSPATH' ) ) exit;
	/**	Set the config components transfert state	*/
	$main_config_components_are_transfered = true;

	$digirisk_current_transfer_state = get_option( '_wpdigirisk-dtransfert', array() );

	/**	Get Danger	*/
	$eva_danger_to_transfer = $eva_danger_transfered = 0;
	$where = "id != 1";
	$eva_danger_categories = $wpdb->get_results( "SELECT * FROM " . TABLE_CATEGORIE_DANGER . " WHERE " . $where . " ORDER BY id ASC" );
	if ( !empty( $eva_danger_categories ) ) :
		$eva_danger_to_transfer += count( $eva_danger_categories );
		foreach ( $eva_danger_categories as $eva_danger_category ) :
			$query = $wpdb->prepare( "SELECT * FROM " . TABLE_DANGER . " WHERE id_categorie = %d ORDER BY nom ASC", $eva_danger_category->id );
			$eva_dangers = $wpdb->get_results( $query );
			$eva_danger_to_transfer += count( $eva_dangers );
		endforeach;
	endif;
	if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'danger' ] ) ) {
		$eva_danger_transfered += count( $digirisk_current_transfer_state[ 'danger' ] ) - 1;
	}
	if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'danger_category' ] ) ) {
		$eva_danger_transfered += count( $digirisk_current_transfer_state[ 'danger_category' ] ) - 1;
	}
	if ( $eva_danger_to_transfer > $eva_danger_transfered ) {
		$main_config_components_are_transfered = false;
	}

	/**	Get Evalation method	*/
	$method_to_transfer = $method_transfered = 0;
	$t = TABLE_METHODE;
	$methods = $wpdb->get_results( "SELECT * FROM {$t} WHERE 1 ORDER BY id ASC");
	if ( !empty( $methods ) ) :
		$method_to_transfer += count( $methods );
	endif;
	if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'evaluation_method' ] ) ) {
		$method_transfered += count( $digirisk_current_transfer_state[ 'evaluation_method' ] ) - 1;
	}
	if ( $method_to_transfer > $method_transfered ) {
		$main_config_components_are_transfered = false;
	}

	/**	Get Recommendation	*/
	$recommendation_to_transfer = $recommendation_transfered = 0;
	$query = $wpdb->prepare(
			"SELECT RECOMMANDATION_CAT.*, PIC.photo
			FROM " . TABLE_CATEGORIE_PRECONISATION . " AS RECOMMANDATION_CAT
				LEFT JOIN " . TABLE_PHOTO_LIAISON . " AS LINK_ELT_PIC ON ((LINK_ELT_PIC.idElement = RECOMMANDATION_CAT.id) AND (tableElement = '" . TABLE_CATEGORIE_PRECONISATION . "') AND (LINK_ELT_PIC.isMainPicture = 'yes'))
				LEFT JOIN " . TABLE_PHOTO . " AS PIC ON ((PIC.id = LINK_ELT_PIC.idPhoto))
			WHERE RECOMMANDATION_CAT.status = %s
				GROUP BY RECOMMANDATION_CAT.id", 'valid');
	$recommendation_categories = $wpdb->get_results( $query );
	if ( !empty( $recommendation_categories ) ) :
		$recommendation_to_transfer += count( $recommendation_categories );
		foreach ( $recommendation_categories as $recommendation_category ) :
			$query = $wpdb->prepare(
					"SELECT RECOMMANDATION.*, PIC.photo
				FROM " . TABLE_PRECONISATION . " AS RECOMMANDATION
					LEFT JOIN " . TABLE_PHOTO_LIAISON . " AS LINK_ELT_PIC ON ((LINK_ELT_PIC.idElement = RECOMMANDATION.id) AND (tableElement = '" . TABLE_PRECONISATION . "') AND (LINK_ELT_PIC.isMainPicture = 'yes') AND (LINK_ELT_PIC.status = 'valid'))
					LEFT JOIN " . TABLE_PHOTO . " AS PIC ON ((PIC.id = LINK_ELT_PIC.idPhoto) AND (PIC.status = 'valid'))
				WHERE RECOMMANDATION.status = 'valid'
					AND RECOMMANDATION.id_categorie_preconisation = %d", $recommendation_category->id );
			$recommendations = $wpdb->get_results( $query );
			$recommendation_to_transfer += count( $recommendations );
		endforeach;
	endif;
	if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'recommendation' ] ) ) {
		$recommendation_transfered += count( $digirisk_current_transfer_state[ 'recommendation' ] ) - 1;
	}
	if ( !empty( $digirisk_current_transfer_state ) && !empty( $digirisk_current_transfer_state[ 'recommendation_category' ] ) ) {
		$recommendation_transfered += count( $digirisk_current_transfer_state[ 'recommendation_category' ] ) - 1;
	}
	if ( $recommendation_to_transfer > $recommendation_transfered ) {
		$main_config_components_are_transfered = false;
	}

?>
		<li class="wp-digi-transfert-components" >
			<div class="wp-digi-datastransfer-element-type-name<?php if ( $main_config_components_are_transfered ) : echo ' dashicons-before dashicons-yes'; endif; ?> "><?php _e( 'General components', 'wp-digi-dtrans-i18n' ); ?></div>
			<ul class="wp-digi-datastransfer-element-type-detail" >
				<li><?php _e( 'Danger', 'wp-digi-dtrans-i18n' ); ?> : <span><?php echo $eva_danger_transfered; ?> / <?php echo $eva_danger_to_transfer; ?></span></li>
				<li><?php _e( 'Method', 'wp-digi-dtrans-i18n' ); ?> : <span><?php echo $method_transfered; ?> / <?php echo $method_to_transfer; ?></span></li>
				<li><?php _e( 'Recommendation', 'wp-digi-dtrans-i18n' ); ?> : <span><?php echo $recommendation_transfered; ?> / <?php echo $recommendation_to_transfer; ?></span></li>
			</ul>
		</li>
