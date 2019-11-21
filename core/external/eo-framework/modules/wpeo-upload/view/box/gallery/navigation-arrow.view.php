<?php
/**
 * Arrow for navigate in the gallery.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 0.1.0-alpha
 * @version 1.0.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\Gallery\View
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php if ( 'false' === $data['single'] && 1 !== count( $list_id ) ) : ?>
	<ul class="navigation">
		<li class="navigation-prev"><a href="#" class="prev"><i class="dashicons dashicons-arrow-left-alt2"></i></a></li>
		<li class="navigation-next"><a href="#" class="next"><i class="dashicons dashicons-arrow-right-alt2"></i></a></li>
	</ul>
<?php endif; ?>
