<?php
/**
 * Informations sur la société.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.10.0
 * @version 6.2.10.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<section class="details">
	<header>
		<p class="note">
			<?php
			esc_html_e( 'Dernières mise à jour le', 'digirisk' );
			echo ' ' . esc_html( $historic_update['date'] );
			echo ' : ' . $historic_update['content'];
			?>
		</p>

		<ul class="grid-layout w3 margin">
			<li class="statistic">
				<span class="number"><?php echo esc_html( $number_risks ); ?></span>
				<span class="label"><?php esc_html_e( 'Nombre de risque', 'digirisk' ); ?></span>
			</li>

			<li class="statistic">
				<span class="number"><?php echo ! empty( $more_dangerous_risk->unique_identifier ) ? esc_html( $more_dangerous_risk->unique_identifier ) : esc_html( 'N/A', 'digirisk' ); ?></span>
				<span class="label"><?php esc_html_e( 'Le risque le plus élevé', 'digirisk' ); ?></span>
			</li>

			<li class="statistic">
				<span class="number"><?php echo esc_attr( $total_cotation ); ?></span>
				<span class="label"><?php esc_html_e( 'Somme des cotations', 'digirisk' ); ?></span>
			</li>
		</ul>
	</header>

</section>

<?php
\eoxia\View_Util::exec( 'digirisk', 'society', 'informations/configuration-form', array(
	'element' => $element,
	'address' => $address,
	'owner_user' => $owner_user,
) );
