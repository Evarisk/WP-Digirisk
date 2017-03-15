<?php
/**
 * La vue principale pour les mises à jour.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.8.0
 * @version 6.2.8.0
 * @copyright 2015-2017 Evarisk
 * @package update-manager
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<?php

if ( ! empty( $availables_update ) ) :
	foreach ( $availables_update as $available_update ) :
		?><input type="hidden" name="version_available[]" value="<?php echo esc_attr( $available_update ); ?>" /><?php
	endforeach;
endif;

if ( ! empty( $versions_data ) ) :
	foreach ( $versions_data as $version => $version_data ) :
		if ( ! empty( $version_data ) ) :
			foreach ( $version_data as $data ) :
				?>
				<input type="hidden" name="version[<?php echo esc_attr( $version ); ?>][action]" value="<?php echo esc_attr( $data['action'] ); ?>" />
				<input type="hidden" name="version[<?php echo esc_attr( $version ); ?>][description]" value="<?php echo esc_attr( $data['description'] ); ?>" />
				<?php
			endforeach;
		endif;

	endforeach;
endif;

?>

<ul class="log"></ul>
