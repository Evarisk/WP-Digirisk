<?php if ( !defined( 'ABSPATH' ) ) exit;

abstract class singleton_util {
  protected static $instance;

	/**
	* Appelle le constructeur parent
	*/
  protected final function __construct() { $this->construct(); }
  abstract protected function construct();

	/**
	* Récupères l'instance courante
	*/
  final public static function g() {
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
