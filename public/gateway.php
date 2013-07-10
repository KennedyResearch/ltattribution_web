<?php
ini_set("display_errors", 1);
$dir = dirname(__FILE__);
$webroot = $_SERVER['DOCUMENT_ROOT'];
$configfile = "$dir/amf_config.ini";

// Setup include path
	//add zend directory to include path
set_include_path(get_include_path().PATH_SEPARATOR.'/var/www/html/ltattribution/ZendFramework/library');
// Initialize Zend Framework loader
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();
// Load configuration
$default_config = new Zend_Config(array("production" => false), true);
$default_config->merge(new Zend_Config_Ini($configfile, 'zendamf'));
$default_config->setReadOnly();
$amf = $default_config->amf;

// Store configuration in the registry
Zend_Registry::set("amf-config", $amf);
// Initialize AMF Server
$server = new Zend_Amf_Server();
$server->setProduction($amf->production);
if(isset($amf->directories)) {
	$dirs = $amf->directories->toArray();
	foreach($dirs as $dir) {
	    // get the first character of the path. 
	    // If it does not start with slash then it implies that the path is relative to webroot. Else it will be treated as absolute path
	    $length = strlen($dir);
	    $firstChar = $dir;
	    if($length >= 1)
	    	$firstChar = $dir[0];
	    
	    if($firstChar != "/"){
	    	// if the directory is ./ path then we add the webroot only.
	    	if($dir == "./"){	    		
	    		$server->addDirectory($webroot);
	    	}else{
	    		$tempPath = $webroot . "/" . $dir;
				$server->addDirectory($tempPath);
			}	    
		}else{
	   		$server->addDirectory($dir);	    	
		}
	}
}
// Initialize introspector for non-production
if(!$amf->production) {
	$server->setClass('Zend_Amf_Adobe_Introspector', '', array("config" => $default_config, "server" => $server));
	$server->setClass('Zend_Amf_Adobe_DbInspector', '', array("config" => $default_config, "server" => $server));
}
// Handle request
echo $server->handle();
