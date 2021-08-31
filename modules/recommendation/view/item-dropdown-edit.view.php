<?php
/**
 * Le template de la signalisation en mode "vue".
 *
 * Ce template est appelé par le shortcode dropdown_recommendation lorsque le paramètre display est égale à "view".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.0.0
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<input type="hidden" name="recommendation_category_id" value='<?php echo esc_attr( $recommendation->data['recommendation_category']->data['id'] ); ?>' />

<input class="input-hidden-recommendation" type="hidden" name="recommendation_category_id" value='-1' />

<div class="wpeo-dropdown dropdown-large categorie-container padding tooltip red"
	 aria-label="<?php esc_html_e( 'Vous devez choisir une signalisation.', 'digirisk' ); ?>">

	<div class="dropdown-toggle dropdown-add-button categorie-container padding wpeo-tooltip-event" aria-label="<?php echo esc_attr( $recommendation->data['recommendation_category']->data['name'] ); ?>">
		<?php echo wp_get_attachment_image( $recommendation->data['recommendation_category']->data['thumbnail_id'], array(50,50), false ); ?>
	</div>

	<ul class="dropdown-content wpeo-grid grid-6" style="width: 400px;">
		<?php
		if ( ! empty( $recommendation_categories ) ) :
			foreach ( $recommendation_categories as $recommendation_category ) :
				?>
				<li class="item dropdown-item wpeo-tooltip-event" aria-label="<?php echo esc_attr( $recommendation_category->data['name'] ); ?>"
					data-id="<?php echo esc_attr( $recommendation_category->data['id'] ); ?>">
					<?php echo wp_get_attachment_image( $recommendation_category->data['thumbnail_id'], array(50,50), false ); ?>
				</li>
			<?php
			endforeach;
		endif;
		?>
	</ul>
</div>
