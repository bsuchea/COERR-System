<?php

require_once '../core/init.php';

$usr = new User;

// DB table to use
$table = 'v_log';

// Table's primary key
$primaryKey = 'date';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'date', 'dt' => 0 ),
	array( 'db' => 'username',  'dt' => 1 ),
	array( 'db' => 'name',   'dt' => 2 ),
	array( 'db' => 'function',     'dt' => 3 ),
	array( 'db' => 'action',     'dt' => 4 )
);


// SQL server connection information
$sql_details = array(
	'user' => Config::get('mysql/username'),
	'pass' => Config::get('mysql/password'),
	'db'   => Config::get('mysql/db'),
	'host' => Config::get('mysql/host')
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */


echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);


