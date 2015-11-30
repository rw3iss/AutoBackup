<?php
//assume running from command line

require_once "config.php";

global $backups;
global $backupDestination;

//go through each backup location, copy to destination
foreach($backups as $bl) {
	$fullBackupDestination = $backupDestination . $bl;
	
	if(is_dir($bl)) {
		ensure_directory($fullBackupDestination);
		recursive_copy_directory($bl, $fullBackupDestination);
	} else {
		$destinationDirectory = dirname($fullBackupDestination);
		ensure_directory($destinationDirectory);
		//ensure_directory($destinationDirectory);
		copy($bl, $fullBackupDestination);
	}

	echo "\nBacked up: " . $fullBackupDestination;
}
echo "\nDone!\n";

function ensure_directory($dir) {
	if (!file_exists($dir)) {
	    mkdir($dir, 0777, true);
	}
}

function recursive_copy_directory($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recursive_copy_directory($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
} 

?>
