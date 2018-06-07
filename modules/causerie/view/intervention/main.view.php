<?php
/**
 * Affiches la liste des causeries
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap digirisk-wrap causerie-wrap">
	<div>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>"><?php esc_html_e( 'Retour', 'digirisk' ); ?></a>

		<h2><?php esc_html_e( 'Causerie en cours', 'digirisk' ); ?></h2>

		<div class="step">
			<ul class="step-list">
				<li class="step <?php echo ( 1 === $final_causerie->current_step ) ? 'active' : ''; ?>"><span class="title"><?php esc_html_e( 'Signature du formateur', 'digirisk' ); ?></span></li>
				<li class="step <?php echo ( 2 === $final_causerie->current_step ) ? 'active' : ''; ?>" data-width="50"><span class="title"><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span></li>
				<li class="step <?php echo ( 3 === $final_causerie->current_step ) ? 'active' : ''; ?>" data-width="100"><span class="title"><?php esc_html_e( 'Enregistrement des participants', 'digirisk' ); ?></span></li>
			</ul>

			<div class="bar">
				<div class="background"></div>
				<div class="loader" data-width="<?php echo esc_attr( 50 * ( $final_causerie->current_step - 1 ) ); ?>" style="width: <?php echo esc_attr( 50 * ( $final_causerie->current_step - 1 ) ); ?>%;"></div>
			</div>
		</div>

		<div class="main-content step-<?php echo esc_attr( $final_causerie->current_step ); ?>">
			<h3>
				<strong><?php echo esc_html( $final_causerie->unique_identifier . ' ' . $final_causerie->second_identifier ); ?></strong>
				<span><?php echo esc_html( $final_causerie->title ); ?></span>
				<span><?php echo esc_html( $final_causerie->risk_category->name ); ?></span>
			</h3>

			<p><?php echo esc_html( $final_causerie->content ); ?></p>

			<div class="ajax-content">
				<?php
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-' . $final_causerie->current_step, array(
					'main_causerie'  => $main_causerie,
					'final_causerie' => $final_causerie,
				) );
				?>
			</div>
		</div>
	</div>
</div>
