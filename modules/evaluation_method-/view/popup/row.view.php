<?php
/**
 * La ligne des valeurs des variables de l'évaluation complexe de digirisk
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-row">
	<div class="table-cell"><?php echo esc_html( $variable->data['name'] ); ?></div>

	<?php
	if ( ! empty( $variable->data['survey']['request'] ) ) :
		foreach ( $variable->data['survey']['request'] as $request ) :
			$is_active = '';

			if ( $request['seuil'] == $selected_seuil && isset( $request['seuil'] ) ) :
				$is_active = 'active';
			endif;
			?>
			<div class="table-cell <?php echo isset( $request['seuil'] ) ? esc_attr( 'can-select' ) : ''; ?> <?php echo esc_attr( $is_active ); ?>"
				data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
				data-evaluation-id="<?php echo esc_attr( $evaluation_id ); ?>"
				data-variable-id="<?php echo esc_attr( $variable->data['id'] ); ?>"
				data-seuil="<?php echo esc_attr( $request['seuil'] ); ?>"><?php echo esc_html( $request['question'] ); ?></div>
			<?php
		endforeach;
	endif;
	?>
</div>
