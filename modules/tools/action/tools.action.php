<?php if ( !defined( 'ABSPATH' ) ) exit;

class tools_action {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'wp_ajax_reset_method_evaluation', array( $this, 'callback_reset_method_evaluation' ) );
		add_action( 'wp_ajax_compil_risk_list', array( $this, 'callback_risk_compilation' ) );
	}

	public function admin_menu() {
    add_management_page( 'Digirisk', 'Digirisk', 'manage_options', 'digirisk-tools', array( $this, 'add_management_page' ) );
  }

  public function add_management_page() {
    require( TOOLS_TEMPLATES_MAIN_DIR . '/main.php' );
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
}

new tools_action();
