<?php
/**
 * Ce template affiche la liste des résultats de la recherche.
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

if ( ! empty( $results ) ) :
	foreach ( $results as $result ) :
		?>
		<li data-id="<?php echo esc_attr( $result->data['id'] ); ?>" data-result="<?php echo esc_html( $result->data['displayname'] ); ?>" class="autocomplete-result">
			<?php echo get_avatar( $result->data['id'], 32, '', '', array( 'class' => 'autocomplete-result-image autocomplete-image-rounded' ) ); ?>
			<div class="autocomplete-result-container">
				<span class="autocomplete-result-title"><?php echo esc_html( $result->data['displayname'] ); ?></span>
				<span class="autocomplete-result-subtitle"><?php echo esc_html( $result->data['email'] ); ?></span>
			</div>
		</li>
		<?php
	endforeach;
else :
	?>
	<li class="autocomplete-result">
		<div class="autocomplete-result-container">
			<span class="autocomplete-result-title"><?php esc_html_e( 'Aucun résultat pour cette recherche', 'digirisk' ); ?></span>
		</div>
	</li>
	<?php
endif;
