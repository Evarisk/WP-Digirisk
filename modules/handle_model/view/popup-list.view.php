<?php
/**
 * Les historiques des documents.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.3.0
 * @copyright 2015-2016 Eoxia
 * @package handle_model
 * @subpackage view
 */

namespace digi;


if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul>
<?php
if ( ! empty( $models ) ) :
	foreach ( $models as $element ) :
		?>
		<li>
			<span>
				<a href="<?php echo esc_attr( $element->url ); ?>" class="wp-digi-bton-second">
					<i class="dashicons-download dashicons"></i>Télécharger ce modèle (<?php echo esc_html( $element->date ); ?>)
					<?php
					if ( $default_model_id === $element->id ) :
						?><strong><br />Ce modèle est le modèle par défaut</strong><?php
					endif;
					?>
				</a>
			</span>
		</li>
		<?php
	endforeach;
else :
	?>
	<li><?php esc_html_e( 'Aucun historique de modèle personnalisé.', 'digirisk' ); ?>
	<?php
endif;
?>
</ul>
