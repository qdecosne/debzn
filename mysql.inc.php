<?php

define( 'MYSQL_INCLUDE', 1 );

if (!defined(MYSQL_INCLUDE)) { require_once( INCLUDEPATH .'mysql.php' ); }

$options['hostname'] = 'localhost'; // Hostname
$options['username'] = 'root'; // Username
$options['password'] = 'nine11'; // Password
$options['dbname'] = 'debzn'; // Database name

$db = new mysql( $options );
$db->connect();
?>