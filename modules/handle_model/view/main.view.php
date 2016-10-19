<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

if ( !empty( $list_type_document ) ):
	foreach ( $list_type_document as $key => $title ):
		?>
		<div class="block">
			<div>
				<h3><?php echo $title; ?></h3>
				<div class="wp-digi-bton-first upload">
					<?php do_shortcode( '[eo_upload_button action="eo_set_model" type="' . $key . '"]' ); ?>
					<span>Envoyer votre modèle personnalisé</span>
				</div>
				<a href="<?php echo $list_document_default[$key]['model_url']; ?>" class="wp-digi-bton-second"><i class="dashicons-download dashicons"></i>Télécharger le modèle courant</a>
			</div>
		</div>
		<?php
	endforeach;
endif;
?>
