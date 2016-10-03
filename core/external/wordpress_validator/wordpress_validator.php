<?php

require 'wordpress_validator.config.php';
require 'class/file.class.php';
require 'test/request.test.php';

$file_class = new file_class();
$list_file = $file_class->search_file( PLUGIN_DIGIRISK_PATH, "/^.*\.php$/" );

$request_test = new request_test( $list_file );
$request_test->execute();


?>
