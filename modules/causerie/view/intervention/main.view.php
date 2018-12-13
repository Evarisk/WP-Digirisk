<?php
/**
 * Affiches la liste des causeries
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap digirisk-wrap causerie-wrap wpeo-wrap">
	<div>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>"><?php esc_html_e( 'Retour', 'digirisk' ); ?></a>

		<h2><?php esc_html_e( 'Causerie en cours', 'digirisk' ); ?></h2>

		<div class="step">
			<ul class="step-list">
				<li class="step <?php echo ( in_array( $final_causerie->data['current_step'], array( 1, 2, 3 ) ) ) ? 'active' : ''; ?>"><span class="title"><?php esc_html_e( 'Signature du formateur', 'digirisk' ); ?></span></li>
				<li class="step <?php echo ( in_array( $final_causerie->data['current_step'], array( 2, 3 ) ) ) ? 'active' : ''; ?>" data-width="50"><span class="title"><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span></li>
				<li class="step <?php echo ( 3 === $final_causerie->data['current_step'] ) ? 'active' : ''; ?>" data-width="100"><span class="title"><?php esc_html_e( 'Enregistrement des participants', 'digirisk' ); ?></span></li>
			</ul>

			<div class="bar">
				<div class="background"></div>
				<div class="loader" data-width="<?php echo esc_attr( 50 * ( $final_causerie->data['current_step'] - 1 ) ); ?>" style="width: <?php echo esc_attr( 50 * ( $final_causerie->data['current_step'] - 1 ) ); ?>%;"></div>
			</div>
		</div>

		<div class="main-content step-<?php echo esc_attr( $final_causerie->data['current_step'] ); ?>">
			<h2 class="causerie-title">
				<strong><?php echo esc_html( $final_causerie->data['unique_identifier'] . ' ' . $final_causerie->data['second_identifier'] ); ?></strong>
				<span><?php echo esc_html( $final_causerie->data['title'] ); ?></span>
				<span><?php echo esc_html( $final_causerie->data['risk_category']->data['name'] ); ?></span>
			</h2>

			<p class="causerie-description"><?php echo nl2br( $final_causerie->data['content'] ); ?></p>

			<div class="ajax-content">
				<?php
				if ( $final_causerie->data['current_step'] < 4 ) :
					\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-' . $final_causerie->data['current_step'], array(
						'main_causerie'  => $main_causerie,
						'final_causerie' => $final_causerie,
						'all_signed'     => $all_signed,
						'user'           => $user,
						'signature_id'   => 0,
					) );
				else :
					?>
					<h3><?php esc_html_e( 'Cette causerie a déjà était faites.', 'digirisk' ); ?></h3>
					<?php
				endif;
				?>
			</div>
		</div>
	</div>
</div>
