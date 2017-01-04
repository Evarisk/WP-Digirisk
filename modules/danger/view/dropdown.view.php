<?php
/**
 * La liste des catégorie de danger
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package danger
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="categorie-container toggle grid padding">

	<div class="action">
		<span>Choisir un risque</span>
		<i class="icon animated fa fa-angle-down"></i>
	</div>

	<ul class="content">
		<?php foreach ( $danger_category_list as $danger_category ) : ?>
			<?php if ( ! empty( $danger_category->danger ) ) : ?>
				<?php foreach ( $danger_category->danger as $danger ) : ?>
					<li class="item" data-id="<?php echo esc_attr( $danger->id ); ?>"><?php echo wp_get_attachment_image( $danger->thumbnail_id, 'thumbnail', false, array( 'title' => $danger->name ) ); ?></li>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>
