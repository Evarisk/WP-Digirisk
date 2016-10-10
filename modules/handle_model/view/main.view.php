<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

?>
	<ul>
	<?php

	if ( !empty( $list_type_document ) ):
	  foreach ( $list_type_document as $key => $element ):
			?>
			<li>
				<?php do_shortcode( '[eo_upload_button action="eo_set_model" title="' . $element . '" type="' . $key . '"]' ); ?>
				<a href="<?php echo $list_document_default[$key]['model_path']; ?>">Télécharger le modèle</a>
			</li>
			<?php
		endforeach;
	endif;
	?>
	</ul>
