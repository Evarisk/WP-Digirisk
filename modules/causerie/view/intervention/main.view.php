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
		<div style="display : inline; float: left;">
			<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>" style="width: 40px; text-decoration :  none">
				<i class="fas fa-arrow-left fa-3x" style="color: blue"></i>
			</a>
			<span style="margin-left: 20px;font-size:55px;"><?php esc_html_e( 'Causerie en cours', 'digirisk' ); ?></span>
		</div>

		<div class="step">
			<ul class="step-list" style="padding-top: 20px;">
				<li class="step <?php echo ( in_array( $final_causerie->data['current_step'], array( 1, 2, 3, 4 ) ) ) ? 'active' : ''; ?>"><span class="title"><?php esc_html_e( 'Signature du formateur', 'digirisk' ); ?></span></li>
				<li class="step <?php echo ( in_array( $final_causerie->data['current_step'], array( 2, 3, 4 ) ) ) ? 'active' : ''; ?>" data-width="37"><span class="title"><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span></li>
				<li class="step <?php echo ( in_array( $final_causerie->data['current_step'], array( 3, 4 ) ) ) ? 'active' : ''; ?>" data-width="62"><span class="title"><?php esc_html_e( 'Tache liée', 'digirisk' ); ?></span></li>
				<li class="step <?php echo ( 4 === $final_causerie->data['current_step'] ) ? 'active' : ''; ?>" data-width="100"><span class="title" style="max-width : none !important;"><?php esc_html_e( 'Enregistrement des participants', 'digirisk' ); ?></span></li>
			</ul>

			<div class="bar" style="top : -35px">
				<div class="background"></div>
				<div class="loader" data-width="<?php echo esc_attr( 37,5 * ( $final_causerie->data['current_step'] - 1 ) ); ?>" style="width:
				<?php if( $final_causerie->data['current_step'] == 4 ): echo '100%' ;
				elseif( $final_causerie->data['current_step'] == 3 ): echo '62%';
				elseif( $final_causerie->data['current_step'] == 2 ): echo '37%';
				else: echo '0%' ; endif; ?>	">
				</div>
			</div>
		</div>

		<div class="main-content step-<?php echo esc_attr( $final_causerie->data['current_step'] ); ?>" style="margin-top: -15px;" >
			<h2 class="causerie-title">
				<strong><?php echo esc_html( $final_causerie->data['unique_identifier'] . ' ' . $final_causerie->data['second_identifier'] ); ?></strong>
				<span><?php echo esc_html( $final_causerie->data['title'] ); ?></span>
				<span><?php echo esc_html( $final_causerie->data['risk_category']->data['name'] ); ?></span>
			</h2>

			<p class="causerie-description"><?php echo nl2br( $final_causerie->data['content'] ); ?></p>

			<div class="ajax-content">
				<?php
				if ( $final_causerie->data['current_step'] < 5 ) :
					\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-' . $final_causerie->data['current_step'], array(
						'main_causerie'  => $main_causerie,
						'final_causerie' => $final_causerie,
						'all_signed'     => $all_signed,
						'user'           => $user,
						'signature_id'   => 0,
						'task'           => $task
					) );
				else :
					?>
					<h3><?php esc_html_e( 'Cette causerie a déjà été faite.', 'digirisk' ); ?></h3>
					<?php
				endif;
				?>
			</div>
		</div>
	</div>
</div>
