<?php

define( MYSQLINC_INCLUDE, 1 );

if (!defined(MYSQL_INCLUDE)) { require_once( INCLUDEPATH .'mysql.php' ); }

$options['hostname'] = 'localhost'; // Hostname
$options['username'] = 'debzn'; // Username
$options['password'] = 'debzn'; // Password
$options['dbname'] = 'debzn'; // Database name

$db = new mysql( $options );
$db->connect();
?>