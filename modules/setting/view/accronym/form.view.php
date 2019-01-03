<?php
/**
 * Affichage principale du formulaire pour gérer les accronymes.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi; ?>

<form method="post" action="<?php echo esc_attr( admin_url( 'admin-post.php' ) ); ?>">
	<input type="hidden" name="action" value="update_accronym" />
	<?php wp_nonce_field( 'update_accronym' ); ?>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'setting', 'accronym/list-item', array(
		'list_accronym' => $list_accronym,
	) );
	?>

	<?php echo submit_button( 'Save', 'primary blue' ); ?>
</form>
