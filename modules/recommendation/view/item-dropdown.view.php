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

<div class="categorie-container padding wpeo-tooltip-event" aria-label="<?php echo esc_attr( $recommendation->data['recommendation_category']->data['name'] ); ?>">
	<?php echo wp_get_attachment_image( $recommendation->data['recommendation_category']->data['thumbnail_id'], 'thumbnail', false ); ?>
</div>
