<?php
/**
* Les actions pour la gestion des fichiers
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package file_management
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class gallery_action {
  public function __construct() {
    add_action( 'wp_ajax_eo_set_thumbnail', array( gallery_class::get(), 'callback_set_thumbnail' ) );
  }
}

new gallery_action();
