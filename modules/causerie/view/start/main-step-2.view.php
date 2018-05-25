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

<div class="wrap digirisk-wrap">
	<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>"><?php esc_html_e( 'Retour', 'digirisk' ); ?></a>

	<h2><?php esc_html_e( 'Causerie en cours', 'digirisk' ); ?></h2>

	<div class="step install">
		<ul class="step-list">
			<li class="step"><span class="title"><?php esc_html_e( 'Signature du formateur', 'digirisk' ); ?></span></li>
			<li class="step active" data-width="50"><span class="title"><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span></li>
			<li class="step" data-width="100"><span class="title"><?php esc_html_e( 'Enregistrement des participants', 'digirisk' ); ?></span></li>
		</ul>
		<div class="bar">
			<div class="background"></div>
			<div class="loader" data-width="0"></div>
		</div>
	</div>

	<div class="main-content">
		<p>Causerie XXX - Risque associé</p>
		<p>Description de ouf</p>

		<?php
		if ( ! empty( $final_causerie->associated_document_id['image'] ) ) :
			foreach ( $final_causerie->associated_document_id['image'] as $image_id ) :
				?><img src="<?php echo wp_get_attachment_image_url( $image_id ); ?>" /><?php
			endforeach;
		endif;
		?>

		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie&id=' . $final_causerie->id . '&step=3' ) ); ?>" class="wpeo-button button-main">
			<span><?php esc_html_e( 'Ajouter des participants', 'digirisk' ); ?></span>
		</a>
	</div>
</div>
