<?php
/**
 * Gestion de l'affichage d'un DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<li class='wp-digi-list-item wp-digi-risk-item'>
	<span><?php echo esc_html( $element->unique_identifier ); ?></span>
	<span><?php echo esc_html( $element->title ); ?></span>
	<span class="padded flex-tmp">
		<a href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
			<i class="fa fa-download" aria-hidden="true"></i>
			<?php esc_html_e( 'Affichage légal ', 'digirisk' ); ?>
			<?php echo esc_html( strtoupper( substr( $element->type, 16, 2 ) ) ); ?></a>
	</span>
</li>
