# AutoBackup
A PHP script that you can run as a cronjob, that will automatically backup any directories in the config file, and put them somewhere else (ie. an external drive).

To setup:

Edit config.php, and add directories to the $backups array, and also change the $backupDestination to the drive/directory you want the backup to go into.

Then, add a cronjob to call the script, which usually works like this, from your terminal:
crontab -a

And add this line: * * * * * /usr/bin/php /path/to/the/backup_script.php
 
 (this assumes php is installed at the typical /usr/bin/php directory)

You can replace the asterisks with these values, in order:
* minute (from 0 to 59)
* hour (from 0 to 23)
* day of month (from 1 to 31)
* month (from 1 to 12)
* day of week (from 0 to 6) (0=Sunday)
* (* means every)

You can also do ranges (ie: * * * * 0-2 for only Sunday to Tuesday), as well as multiples (* * * * 1,3,5 for only Monday and Wednesday and Friday, etc)

Example: To run the script every night at midnight, enter:

0 0 * * * /usr/bin/php /path/to/the/backup_script.php

Then save the file, and the cronjab will automatically be activated.


