<?php
/**
 * Affiches le champs de texte et le bouton "Plus" pour créer une unité de travail.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.6.0
 * @copyright 2015-2017 Evarisk
 * @package navigation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="workunit-add tooltip red" aria-label="Le nom de l'unité de travail est obligatoire.">
	<input type="hidden" name="action" value="save_workunit" />
	<input type="hidden" name="groupment_id" value="<?php echo esc_attr( $parent_id ); ?>" />
	<?php wp_nonce_field( 'save_workunit' ); ?>
	<input class="title" type="text" placeholder="<?php _e( 'Nouvelle unité de travail', 'digirisk' ); ?>" name="workunit[title]" />
	<div class="add button disable w50 action-input" data-namespace="digirisk" data-module="navigation" data-before-method="beforeSaveWorkunit" data-loader="workunit-add" data-parent="workunit-add"><i class="icon fa fa-plus"></i></div>
</div>
