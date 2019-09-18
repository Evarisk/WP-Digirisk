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

<div id="container1" class="bigbox">
</div>

<div id="container2" class="bigbox">
</div>

<div id="container3" class="bigbox">
</div>
<div>
	<h2 style="float:left">
		<?php esc_html_e( 'Bibliothèque des causeries', 'digirisk' ); ?>
	</h2>
	<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-setting&tab=digi-define-prefix' ) ); ?>"
		class="wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Modifier la référence des permis de feu', 'digirisk' ); ?>" >
		<div class="wpeo-button button-main" style="float: right;">
			<span><i class="icon fa fa-cog"></i></span>
		</div>
	</a>

	<table class="table add-causerie">
		<thead>
			<tr>
				<th class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
				<th class="w50 padding"><?php esc_html_e( 'Photo', 'digirisk' ); ?>.</th>
				<th class="w50 padding"><?php esc_html_e( 'Cat', 'digirisk' ); ?>.</th>
				<th class="padding"><?php esc_html_e( 'Titre et description', 'digirisk' ); ?>.</th>
				<th class="w150"></th>
			</tr>
		</thead>

		<tbody>
			<?php
			if ( ! empty( $causeries ) ) :
				foreach ( $causeries as $causerie ) :
					$causerie = apply_filters( 'digi_add_custom_key_to_causerie', $causerie );
					\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/list-item', array(
						'causerie' => $causerie
					) );
				endforeach;
			endif;
			?>

			<?php
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/item-edit', array(
				'causerie' => $causerie_schema,
			) );
			?>
		</tbody>
	</table>
	<div class="" style="margin-top: 10px; float: right;">
		<?php \eoxia\View_Util::exec( 'digirisk', 'causerie', 'form/modal/import', array() ); ?>
	</div>

</div>
