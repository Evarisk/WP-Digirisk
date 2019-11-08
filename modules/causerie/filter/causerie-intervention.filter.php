<?php
/**
 * La classe gérant les filtres des causeries
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Causerie.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les filtres des causeries
 */
class Causerie_Intervention_Filter extends Identifier_Filter {

	public function __construct() {
		$current_type = Causerie_Class::g()->get_type();
		add_filter( "eo_model_digi-final-causerie_after_get", array( $this, 'get_full_causerie_intervention' ), 11, 2 );
		add_filter( 'wp_get_attachment_url', array( $this, 'honor_ssl_for_attachments' ));

		add_filter( 'eoxia_main_header_before', array( $this, 'back_button' ) );
		add_filter( 'eoxia_main_header_title', array( $this, 'change_title' ) );
	}

	/**
	 * Récupères tous les éléments nécessaires pour le fonctionnement d'une causerie
	 * - Catégorie de risque
	 * - Participants
	 * - Formateur
	 *
	 * @since   6.6.0
	 *
	 * @param  Causerie_Model $data L'objet.
	 * @return Causerie_Model L'objet avec tous les éléments ajoutés par cette méthode.
	 */
	public function get_full_causerie_intervention( $object, $args ) {
		if ( ! empty( $object->data['id'] ) ) {
			$object->data['sheet_intervention'] = Sheet_Causerie_Intervention_Class::g()->get( array(
				'posts_per_page' => 1,
				'post_parent'    => $object->data['id'],
			), true );
		}

		return $object;
	}

	public function honor_ssl_for_attachments($url) {
		$http = site_url(FALSE, 'http');
		$https = site_url(FALSE, 'https');
		return ( is_ssl() ) ? str_replace($http, $https, $url) : $url;
	}

	public function back_button( $content ) {
		if ( 'digirisk-causerie' === $_REQUEST['page'] && isset( $_GET['id'] ) ) {
			ob_start();
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/back-icon' );
			$content .= ob_get_clean();
		}
		return $content;
	}

	public function change_title( $content ) {
		if ( 'digirisk-causerie' === $_REQUEST['page'] && isset( $_GET['id'] ) ) {
			$prevention = Causerie_Intervention_Class::g()->get( array( 'id' => $_GET['id'] ), true );

			$content = __( sprintf( 'Causerie en cours en cours #%s', (int) $_GET['id'] ), 'digirisk' );
		}
		return $content;
	}
}

new Causerie_Intervention_Filter();
