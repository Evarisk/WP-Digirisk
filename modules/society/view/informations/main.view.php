<?php
/**
 * Template pour les informations de la société.
 *
 * Ce template appel également le template pour afficher le formulaire pour régler les informations de la société.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.10
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<section class="details">
	<header>
		<p class="note">
			<?php
			esc_html_e( 'Dernières mise à jour le', 'digirisk' );
			echo ' ' . esc_html( $historic_update['date'] );
			echo ' : ' . $historic_update['content'];
			?>
		</p>

		<ul class="wpeo-gridlayout grid-3 margin">
			<li class="statistic">
				<span class="number"><?php echo esc_html( $number_risks ); ?></span>
				<span class="label"><?php esc_html_e( 'Nombre de risque', 'digirisk' ); ?></span>
			</li>

			<li class="statistic">
				<span class="number"><?php echo ! empty( $more_dangerous_risk->data['unique_identifier'] ) ? esc_html( $more_dangerous_risk->data['unique_identifier'] ) : esc_html( 'N/A', 'digirisk' ); ?></span>
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
) );
