<?php
if(basename($_SERVER['PHP_SELF'])==basename(__FILE__)){
	exit("Access to this page is prohibited.");
}
    $mysql_host="HOST_NAME";
    $mysql_dbname="DB_NAME";
    $mysql_user="USER_NAME";
    $mysql_password="USER_PASSWORD";
    $db = NULL;
    $file_folder="uploads";
?>