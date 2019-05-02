<?php
/**
 * Le template pour afficher la selection de la liste des catégories de signalisation.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.1
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<input class="input-hidden-recommendation" type="hidden" name="recommendation_category_id" value='-1' />

<div class="wpeo-dropdown dropdown-large categorie-container padding tooltip red"
	aria-label="<?php esc_html_e( 'Vous devez choisir une signalisation.', 'digirisk' ); ?>">

	<div class="dropdown-toggle wpeo-button button-transparent">
		<span><?php esc_html_e( 'Signalisation', 'digirisk' ); ?></span>
		<img class="hidden" src="" title="<?php echo esc_attr( 'Signalisation', 'digirisk' ); ?>" />
		<i class="button-icon animated fas fa-angle-down"></i>
	</div>

	<ul class="dropdown-content wpeo-grid grid-6" style="width: 400px;">
		<?php
		if ( ! empty( $recommendation_categories ) ) :
			foreach ( $recommendation_categories as $recommendation_category ) :
				?>
				<li class="item dropdown-item wpeo-tooltip-event" aria-label="<?php echo esc_attr( $recommendation_category->data['name'] ); ?>"
					data-id="<?php echo esc_attr( $recommendation_category->data['id'] ); ?>">
					<?php echo wp_get_attachment_image( $recommendation_category->data['thumbnail_id'], 'thumbnail', false ); ?>
				</li>
				<?php
			endforeach;
		endif;
		?>
	</ul>
</div>
