<?php if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 * Abstract Singleton class for PHP.  Extending classes must define a protected static $instance member.
 */

abstract class singleton_util {
  protected static $instance;

  protected final function __construct() { $this->construct(); }
  abstract protected function construct();

  final public static function get() {
    if ( !isset( self::$instance ) || get_called_class() != get_class( self::$instance ) ) {
      $class_name = get_called_class();
      $new_instance = new $class_name();
      //extending classes can set $instance to any value, so check to make sure it's still unset before giving it the default value.
      if ( !isset( self::$instance ) || get_called_class() != get_class( self::$instance ) ) {
        self::$instance = $new_instance;
      }
    }
    return self::$instance;
  }
}
