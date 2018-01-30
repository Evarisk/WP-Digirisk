<?php
/**
 * Affichage l'interface de correction des risques n'ayant plus de categorie de risque dans digirisk
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.5
 * @version 6.4.5
 * @copyright 2015-2018 Evarisk
 * @package tools
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="digi-danger-categories" class="tab-content hidden grid-layout w2 padding" style="display: none;" >
	<div class="block">
		<div class="container">
			<h3><?php esc_html_e( 'Correction de l\'association des catégories de risques', 'digirisk' ); ?></h3>
			<p class="content"><?php esc_html_e( 'Cliquez sur ce bouton pour corriger le défaut d\'association des catégories de risques aux risques', 'digirisk' ); ?></p>
<?php
// On fait le traitement uniquement si il existe des "anciennes" catégories.
if ( ! empty( $digi_danger_category_list )  ) :
?><table class="digi-tools-category-fixer" style="text-align: left; margin: 10px auto;" >
	<?php foreach ( $digi_danger_category_list as $danger_category ) : ?>
		<tr>
			<td><input name="digi-danger-category" type="hidden" value="<?php echo esc_attr( $danger_category->term_id ); ?>" />#<?php echo esc_html( $danger_category->term_id ); ?> - <?php echo esc_html( $danger_category->name ); ?></td>
			<td>
				<?php if ( ! empty( $digi_category_risk_list ) ) : ?>
					<select name="digi-category-risk" >
					<?php foreach ( $digi_category_risk_list as $category_risk ) : ?>
						<?php
						$is_selected = false;
						if ( is_array( $json_matching ) && ! empty( $json_matching ) && array_key_exists( $danger_category->slug, $json_matching ) && ( $json_matching[ $danger_category->slug ] === $category_risk->slug ) ) {
							$is_selected = true;
						}
						?>
						<option <?php selected( $is_selected, true, true ); ?> value="<?php echo esc_attr( $category_risk->term_id ); ?>" >#<?php echo esc_html( $category_risk->term_id ); ?> - <?php echo esc_html( $category_risk->name ); ?></option>
					<?php endforeach; ?>
					</select>
				<?php endif; ?>
			</td>
			<td class="action-result" ></td>
		</tr>
	<?php endforeach; ?>
	</table>

	<button data-nonce="<?php echo esc_attr( wp_create_nonce( 'digi-fix-danger-categories' ) ); ?>" id="digi-tools-fix-categories" class="button blue" ><?php esc_html_e( 'Corriger les catégories de risques' ); ?></button>
<?php
else :
	esc_html_e( 'Il n\'y a aucune action a effectuer. Votre installation semble correcte.', 'digirisk' );
endif;
?>
		</div>
	</div>
</div>
