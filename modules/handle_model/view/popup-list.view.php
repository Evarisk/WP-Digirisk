<?php
/**
 * Les historiques des documents.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3
 * @version 6.4.0
 * @copyright 2015-2016 Eoxia
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul>
<?php
if ( ! empty( $models ) ) :
	foreach ( $models as $key => $element ) :
		?>
		<li>
			<?php if ( 0 === $key ) : ?>
				<h4>Le modèle par défaut</h4>
			<?php elseif ( 1 === $key ) : ?>
				<h4>Historique des modèles</h4>
			<?php endif; ?>
			<span>
				<a href="<?php echo esc_attr( $element->url ); ?>">
					<i class="dashicons-download dashicons"></i>Télécharger ce modèle (<?php echo esc_html( ! empty( $element->date['date_human_readable'] ) ? $element->date['date_human_readable'] : 'Modèle de Digirisk par défaut' ); ?>)
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
