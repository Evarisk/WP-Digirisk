<?php 
	if(!defined("UNIT_TESTING")) die();
	
	function load_plugin_textdomain($name, $bool, $path)
	{
		echo "[+] Loading plugin -> " . $path . $name . PHP_EOL;
	}
	
	function register_activation_hook( $file, $array )
	{
		$length = 0;
		$hooked = "[";
		foreach($array as $hook)
		{
			$length++;
			$hooked .= $hook . ",";
		}
		if($length > 0) rtrim($hooked, ",");
		$hooked .= "]";
		echo "[+] Registering hook -> " . $file . " in " . $name . PHP_EOL;
	}
	
	function add_filter( $name, $fn, $nbr)
	{
		echo "[+] Adding plugin -> " . $name . " X" . $nbr . PHP_EOL;	
	}
	
	function sanitize_text_field($str)
	{
		echo "[+] Sanitizing -> " . $str . PHP_EOL;	
	}
	
	function plugin_dir_path($path)
	{
		echo "[+] Plugin path -> " . $path . PHP_EOL;	
	}
	
	function site_url()
	{
		$url = "http://testunitaire.dom/";
		echo "[+] Requesting site_url -> " . $url . PHP_EOL;	
		return $url;
	}
	
	function plugin_basename()
	{
		$basename = dirname(__FILE__); 
		echo "[+] Requesting plugin_basename -> " . $basename . PHP_EOL;	
		return $basename;
	}