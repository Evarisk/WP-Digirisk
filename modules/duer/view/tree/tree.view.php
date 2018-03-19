<?php
/**
 * Affichage en mode "arbre" des sociétés pour la popup de la génération du DUER
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $societies ) ) :
	foreach ( $societies as $key => $society ) :
		?>
		<li data-action="generate_establishment"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'generate_establishment' ) ); ?>"
				data-element-id="<?php echo esc_attr( $society->id ); ?>">
			<?php echo esc_html( 'Génération du document ' . $society->unique_identifier . ' - ' . $society->title ); ?>
			<img src="<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>" alt="<?php echo esc_attr( 'Chargement...' ); ?>" />
		</li>

		<?php
		DUER_Class::g()->display_childs( $society->id );
	endforeach;
endif;
