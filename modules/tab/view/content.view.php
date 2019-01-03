<?php
/**
 * Affiches le contenu principale
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<h1><?php echo esc_html( $tab->title ); ?></h1>
<?php echo do_shortcode( '[' . $tab->slug . ' post_id="' . $id . '" ]' ); ?>
