<?php
/**
 * La vue principale de la page "Risques"
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @copyright 2015-2019 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="digirisk-wrap wpeo-wrap risk-page">
	
	<h2>Tous les risques</h2>
	
	<form method="GET" action="<?php echo admin_url( 'admin.php' ); ?>" class="">
		<input type="hidden" name="page" value="digirisk-handle-risk" />
		<div class="form-element" style="float: left;">
			<span class="form-label">Catégorie de risque</span>
			<label class="form-field-container">
				<select name="category_risk_id" class="form-field">
					<option value="0">Toutes les catégories</option>
					<?php 
					if ( ! empty( $risk_categories ) ) :
						foreach ( $risk_categories as $category ) :
							$selected = '';
							
							if ( $category->data['id'] == $_GET['category_risk_id'] ) :
								$selected = 'selected="selected"';
							endif;
							?>
							<option <?php echo $selected; ?> value="<?php echo $category->data['id']; ?>"><?php echo esc_attr( $category->data['name'] ); ?></option>
							<?php
						endforeach;
					endif;
					?>
				</select>
			</label>
		</div>
		
		<div class="form-element">
			<input type="submit" value="Filtrer" />
		</div>
	</form>

	<table class="table risk">
		<?php Risk_Page_Class::g()->display_risk_list(); ?>
	</table>

	<a href="#" class="wpeo-button button-disable button-green button-margin save-all alignright"><?php esc_html_e( 'Enregistrer', 'digirisk' ); ?></a>

	<!-- Pagination -->
	<?php if ( ! empty( $current_page ) && ! empty( $number_page ) ) : ?>
		<div class="wp-digi-pagination">
			<?php
			$big = 999999999;
			echo paginate_links( array(
				'base'               => admin_url( 'admin-ajax.php?action=paginate_risk&current_page=%_%' ),
				'format'             => '%#%',
				'current'            => $current_page,
				'total'              => $number_page,
				'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'digirisk' ) . ' </span>',
				'type'               => 'plain',
				'next_text'          => '<i class="dashicons dashicons-arrow-right"></i>',
				'prev_text'          => '<i class="dashicons dashicons-arrow-left"></i>',
			) );
			?>
		</div>
	<?php endif; ?>

</div>
