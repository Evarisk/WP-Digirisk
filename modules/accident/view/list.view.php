<?php
/**
 * Affiches la liste des accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table accident">
	<div class="header">
		<span><?php esc_html_e( 'Ref.', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Nom, Prénom, matricule interne de la victime', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Date et heure', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Lieu', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'NB. jour arrêt', 'digirisk' ); ?></span>
		<span><?php esc_html_e( 'Enquête accident', 'digirisk' ); ?></span>
	</div>

	<?php
	if ( ! empty( $accidents ) ) :
		foreach ( $accidents as $accident ) :
			\eoxia\View_Util::exec( 'digirisk', 'accident', 'list-item', array(
				'accident' => $accident,
			) );
		endforeach;
	endif;
	?>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'accident', 'item-add', array(
		'accident' => $accident_schema,
		'main_society' => $main_society,
	) );
	?>
</div>
