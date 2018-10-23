<?php
/**
 * Affichage du résultat des utilisateurs.
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

defined( 'ABSPATH' ) || exit;

if ( ! empty( $results ) ) :
	foreach ( $results as $user ) :
		?>
		<li data-id="<?php echo esc_attr( $user->data['id'] ); ?>" data-result="<?php echo esc_html( $user->data['displayname'] ); ?>" class="autocomplete-result">
			<?php echo get_avatar( $user->data['id'], 32, '', '', array( 'class' => 'autocomplete-result-image autocomplete-image-rounded' ) ); ?>
			<div class="autocomplete-result-container">
				<span class="autocomplete-result-title"><?php echo esc_html( $user->data['displayname'] ); ?></span>
				<span class="autocomplete-result-subtitle"><?php echo esc_html( $user->data['email'] ); ?></span>
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
