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
class Sheet_Causerie_Filter extends \eoxia001\Singleton_Util {
	protected function construct() {}

	/**
	 * [public description]
	 * @var [type]
	 */
	public function callback_digi_document_identifier( $unique_identifier, $causerie ) {
		$unique_identifier = $causerie->unique_identifier . '_' . $causerie->second_identifier . '_';
		return $unique_identifier;
	}
}

Sheet_Causerie_Filter::g();
