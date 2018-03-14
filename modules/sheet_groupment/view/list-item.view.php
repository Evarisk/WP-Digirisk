<?php
/**
 * Gestion de l'affichage d'une fiche de groupement
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.9
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr>
	<td class="padding"><strong><?php echo esc_html( $element->unique_identifier ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $element->title ); ?></td>
	<td>
		<div class="action">
<<<<<<< HEAD
			<?php if ( ! empty( $element->link ) ) : ?>
			<a class="button purple h50" href="<?php echo esc_attr( $element->link ); ?>">
				<i class="fa fa-download icon" aria-hidden="true"></i>
			</a>
		<?php else : ?>
			<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>">
				<i class="fa fa-times icon" aria-hidden="true"></i>
=======
			<?php if ( ! empty( Document_Class::g()->get_document_path( $element ) ) ) : ?>
			<a class="button purple h50" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
				<i class="fas fa-download icon" aria-hidden="true"></i>
				<!-- <span><?php esc_html_e( 'Fiche de groupement', 'digirisk' ); ?></span> -->
			</a>
		<?php else : ?>
			<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Corrompu', 'digirisk' ); ?>" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
				<i class="far fa-times icon" aria-hidden="true"></i>
>>>>>>> 4193b35d61798b531a1a17e53fabe874155c4b92
			</span>
		<?php endif; ?>
		</div>
	</td>
</tr>
