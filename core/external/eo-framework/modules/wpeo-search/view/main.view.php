<?php
/**
 * Affichage de l'input autocomplete.
 *
 * @author    Eoxia <dev@eoxia.com>
 * @copyright (c) 2015-2018 Eoxia <dev@eoxia.com>.
 *
 * @license   GPLv3 <https://spdx.org/licenses/GPL-3.0-or-later.html>
 *
 * @package   EO_Framework\EO_Search\Template
 *
 * @since     1.1.0
 */

namespace eoxia;

defined( 'ABSPATH' ) || exit; ?>

<div class="form-element">
	<?php
	if ( ! empty( $atts['label'] ) ) :
		?>
		<span class="form-label"><?php esc_html_e( $atts['label'], 'eoframework' ); ?></span>
		<?php
	endif;
	?>

	<input type="hidden" class="eo-search-value" name="<?php echo esc_attr( $atts['name'] ); ?>" value="<?php echo esc_attr( $atts['hidden_value'] ); ?>" />

	<div class="form-field-container">
		<div class="wpeo-autocomplete <?php echo ! empty( $atts['value'] || $atts['hidden_value'] ) ? ' autocomplete-full ' : ''; ?>" data-action="eo_search" data-next-action="<?php echo ! empty( $atts['action'] ) ? esc_attr( $atts['action'] ) : ''; ?>" data-type="<?php echo esc_attr( $atts['type'] ); ?>">
			<input type="hidden" name="slug" value="<?php echo esc_attr( $atts['slug'] ); ?>" />
			<textarea class="hidden" name="args"><?php echo json_encode( $atts ); ?></textarea>
			<label class="autocomplete-label" for="<?php echo esc_attr( $atts['id'] ); ?>">

				<?php
				if ( ! empty( $atts['icon'] ) ) :
					?>
					<i class="autocomplete-icon-before fas <?php echo esc_attr( $atts['icon'] ); ?>"></i>
					<?php
				endif;
				?>

				<input id="<?php echo esc_attr( $atts['id'] ); ?>" autocomplete="off" placeholder="Recherche..." class="autocomplete-search-input" type="text" value="<?php echo esc_attr( $atts['value'] ); ?>" />
				<span class="autocomplete-icon-after"><i class="fas fa-times"></i></span>
			</label>
			<ul class="autocomplete-search-list" style="overflow-y: scroll; max-height: 300px;"></ul>
		</div>
	</div>
</div>
