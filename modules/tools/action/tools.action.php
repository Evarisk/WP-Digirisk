<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class tools_action {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'wp_ajax_reset_method_evaluation', array( $this, 'callback_reset_method_evaluation' ) );
		add_action( 'wp_ajax_compil_risk_list', array( $this, 'callback_risk_compilation' ) );
		add_action( 'wp_ajax_transfert_doc', array( $this, 'callback_transfert_doc' ) );
	}

	public function admin_menu() {
    add_management_page( 'Digirisk', 'Digirisk', 'manage_options', 'digirisk-tools', array( $this, 'add_management_page' ) );
  }

  public function add_management_page() {
		view_util::exec( 'tools', 'main' );
  }

  public function callback_reset_method_evaluation() {
    check_ajax_referer( 'reset_method_evaluation' );

    tools_class::g()->reset_method_evaluation();

    wp_send_json_success();
  }

	/**
	 * Callback function for fixing risk list in element when some errors are detected / Fonction de rappel pour la correction de la liste des risques dans les éléments
	 */
	public function callback_risk_compilation() {
		check_ajax_referer( 'risk_list_compil' );

		/**	First let's list all group / Commençons par lister les groupements	*/
		$group_list = group_class::g()->get( array() );
		foreach ( $group_list as $group ) {
			$risk_list = risk_class::g()->get( array( 'post_parent' => $group->id ) );
			if ( !empty( $risk_list ) ) {
				foreach ( $risk_list as $risk ) {
					$group->associated_risk[] = $risk->id;
				}

				group_class::g()->update( $group );
			}
		}

		/**	Let's list all workunit / Listons les unités de travail */
		$workunit_list = workunit_class::g()->get( array() );
		foreach ( $workunit_list as $workunit ) {
			$risk_list = risk_class::g()->get( array( 'post_parent' => $workunit->id ) );
			if ( !empty( $risk_list ) ) {
				foreach ( $risk_list as $risk ) {
					$workunit->associated_risk[] = $risk->id;
				}

				workunit_class::g()->update( $workunit );
			}
		}

		wp_send_json_success();
	}

	public function callback_transfert_doc() {
		check_ajax_referer( 'callback_transfert_doc' );

		$args = array(
			'post_status' => 'inherit',
			'tax_query' => array(
				array(
					'taxonomy' 	=> document_class::g()->attached_taxonomy_type,
					'field'			=> 'slug',
					'terms'			=> 'document_unique'
				)
			)
		);

		$list_document = document_class::g()->get( $args, array( 'category' ));

		if ( !empty( $list_document ) ) {
		  foreach ( $list_document as $element ) {
				// $element->status = 'trash';

				// document_class::g()->update( $element );
				$element->status = 'publish';
				$element->type = Duer_Class::g()->get_post_type();
				$element->unique_identifier = str_replace( document_class::g()->element_prefix, DUER_Class::g()->element_prefix, $element->unique_identifier );
				DUER_Class::g()->update( $element );
		  }
		}

		wp_send_json_success();
	}
}

new tools_action();
