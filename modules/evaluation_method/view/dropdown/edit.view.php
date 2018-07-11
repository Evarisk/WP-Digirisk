<?php
/**
 * Template permettant d'ouvrir le dropdown avec les cotations simple.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

if ( ! empty( $variables[0]->data['survey']['request'] ) ) :
	foreach ( $variables[0]->data['survey']['request'] as $request ) :
		?>
		<li data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
				data-evaluation-id="<?php echo esc_attr( $method_evaluation_simplified->data['id'] ); ?>"
				data-variable-id="<?php echo esc_attr( $variables[0]->data['id'] ); ?>"
				data-seuil="<?php echo esc_attr( $request['seuil'] ); ?>"
				data-scale="<?php echo esc_attr( $request['seuil'] ); ?>"
				class="dropdown-item cotation"><?php echo esc_html( $method_evaluation_simplified->data['matrix'][ $request['seuil'] ] ); ?></li>
		<?php
	endforeach;
endif;
