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
} ?>

<ul>
	<li data-action="construct_duer"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'construct_duer' ) ); ?>">
		<?php esc_html_e( 'Construction du DUER', 'digirisk' ); ?>
		<img src="<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>" alt="<?php echo esc_attr( 'Chargement...' ); ?>" />
	</li>
	<li data-action="generate_duer"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'generate_duer' ) ); ?>"
			data-parent-id="<?php echo esc_attr( $society->id ); ?>">
		<?php esc_html_e( 'Génération du DUER', 'digirisk' ); ?>
		<img src="<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>" alt="<?php echo esc_attr( 'Chargement...' ); ?>" />
	</li>

	<?php DUER_Class::g()->display_childs( $society->id ); ?>

	<li data-action="generate_zip"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'generate_zip' ) ); ?>">
		<?php esc_html_e( 'Génération du ZIP', 'digirisk' ); ?>
		<img src="<?php echo esc_attr( admin_url( '/images/loading.gif' ) ); ?>" alt="<?php echo esc_attr( 'Chargement...' ); ?>" />
	</li>
</ul>
