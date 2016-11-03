<?php
/**
* Display the action for delete a establishment
* And add a filter for add custom action
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<span class="wp-digi-action">
  <?php apply_filters( 'wpdigi_identity_' . $element->type . '_action', $element->id ); ?>
  <a href="#" data-nonce="<?php echo wp_create_nonce( 'delete_establishment' ); ?>" data-object-name="<?php echo apply_filters( 'wpdigi_object_name_' . $element->type, '' ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
</span>
