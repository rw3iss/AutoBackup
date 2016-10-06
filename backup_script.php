<?php
//assume running from command line
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config.php";

global $backups;
global $backupDestination;

// Goes through each configured backup location, copying the entire directory structure to the destination.
// For Windows systems, origin drive letters will be replaced with just the letter, ie: C:\ => C\

foreach($backups as $bl) {
	$fullBackupDestination = $backupDestination;

	// This script replaces drive letters with just a letter, for Windows systems
	preg_match("/^[a-zA-Z]:\\.*/", $bl, $matches);
	if($matches) {
		$drive = substr($matches[0], 0, 1);
		$blStripped = preg_replace('/^[a-zA-Z]:/', '', $bl);
		$fullBackupDestination .= '\\' . $drive . $blStripped;
	} else {
		$fullBackupDestination .= $bl;
	}

	if(is_dir($bl)) {
		_ensure_directory($fullBackupDestination);
		_recursive_copy_directory($bl, $fullBackupDestination);
	} else {
		$destinationDirectory = dirname($fullBackupDestination);
		_ensure_directory($destinationDirectory);
		//ensure_directory($destinationDirectory);
		copy($bl, $fullBackupDestination);
	}

	echo "\nBacked up: " . $fullBackupDestination;
}

echo "\n\nDone!\n";

function _ensure_directory($dir) {
	if (!file_exists($dir)) {
			echo "\nCreating directory " + $dir;
	    mkdir($dir, 0777, true);
	}
}

function _recursive_copy_directory($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                _recursive_copy_directory($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 

?>
