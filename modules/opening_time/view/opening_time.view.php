<?php
/**
* Formulaire pour gérer les horaires d'ouverture
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package opening_time
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="di-opening-time">
  <label>
    <?php _e( 'Opening time', 'wpdigi-i18n' ); ?>
    <input type="text" class="time-picker" data-type="open" value="09:00"/>
    <?php _e( ':', 'wpdigi-i18n' ); ?>
    <input type="text" class="time-picker" data-type="close" value="18:00" />
  </label>

  <label>
    <?php _e( 'All days', 'wpdigi-i18n' ); ?>
    <input type="checkbox" checked />
  </label>

  <ul class="hidden">
    <?php
    if ( !empty( $list_day ) ) {
      foreach ( $list_day as $key => $element ) {
        ?>
        <li>
          <label>
            <?php echo $element; ?>
            <input name="<?php echo $key; ?>[open]" type="text" class="time-picker open" value="09:00"/>
            <?php _e( ':', 'wpdigi-i18n' ); ?>
            <input name="<?php echo $key; ?>[close]" type="text" class="time-picker close" value="18:00" />
          </label>
        </li>
        <?php
      }
    }
    ?>
  </ul>
</div>
