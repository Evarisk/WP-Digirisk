<?php
/**
 * Icone retour liste des préventions
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     7.5.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<a class="alignleft" href="<?php echo esc_url( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>">
	<div class="wpeo-button button-main button-square-30">
		<span><i class="button-icon fas fa-arrow-left"></span></i>
	</div>
</a>
