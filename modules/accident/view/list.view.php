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

<table class="table accident">
	<thead>
		<tr>
			<th class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="padding tooltip hover w50" aria-label="<?php echo esc_attr_e( 'Nom, Prénom et matricule de la victime', 'digirisk' ); ?>"><?php esc_html_e( 'Nom, Prénom, ..victime', 'digirisk' ); ?></th>
			<th class="padding w50"><?php esc_html_e( 'Date et heure' , 'digirisk' ); ?></th>
			<th class="padding w50"><?php esc_html_e( 'Lieu' , 'digirisk' ); ?></th>

			<th class="padding"><?php esc_html_e( 'Circonstances détaillées', 'digirisk' ); ?></th>
			<th class="padding w50"><?php esc_html_e( 'NB. Jours arrêts', 'digirisk' ); ?></th>
			<th class="padding w50"><?php esc_html_e( 'Enquête accident', 'digirisk' ); ?></th>
			<th class="padding w50"><?php esc_html_e( 'Opt. avancés', 'digirisk' ); ?></th>
			<th class="w100"></th>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $accidents ) ) :
			foreach ( $accidents as $accident ) :
				\eoxia\View_Util::exec( 'digirisk', 'accident', 'list-item', array(
					'accident' => $accident,
				) );
			endforeach;
		endif;
		?>
	</tbody>

	<tfoot>
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'item-edit', array(
			'accident' => $accident_schema,
			'main_society' => $main_society,
		) );
		?>
	</tfoot>
</table>
