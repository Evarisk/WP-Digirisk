<?php
/**
 * Affichage du résultat des posts.
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

namespace digirisk;

use digi\Prevention_Class;

defined( 'ABSPATH' ) || exit;

if ( ! empty( $results ) ) :
	foreach ( $results as $post ) :
		?>
		<li data-id="<?php echo esc_attr( $post->data['id'] ); ?>" data-result="<?php echo esc_html( $post->data['title'] ); ?>" class="autocomplete-result">
			<div class="autocomplete-result-container">
				<span class="autocomplete-result-title"><?php echo esc_html( Prevention_Class::g()->element_prefix . $post->data['unique_identifier_int'] . ' - ' . $post->data['title'] ); ?></span>

				<?php
				if ( ! empty( $post->data['content'] ) ) :
					?>
					<span class="autocomplete-result-subtitle"><?php echo esc_html( substr( $post->data['content'], 0, 30 ) ); ?>...</span>
				<?php
				endif;
				?>
			</div>
		</li>
	<?php
	endforeach;
else :
	?>
	<li class="autocomplete-result">
		<div class="autocomplete-result-container">
			<span class="autocomplete-result-title">Aucun résultat</span>
			<span class="autocomplete-result-subtitle">Avec le terme de recherche: <?php echo esc_html( $term ); ?></span>
	</li>
<?php
endif;
