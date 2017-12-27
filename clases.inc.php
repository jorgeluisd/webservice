<?php 
	
	define("PROJECTPATH", dirname(__DIR__));

	spl_autoload_register(function($class) {
	    $filename = PROJECTPATH . '/backend/' . $class . '.class.php';
	    $filename_real = str_replace(['/',"\\"],DIRECTORY_SEPARATOR,$filename);
	    require $filename_real; 
	});
?>