<?php

require_once '../core/init.php';

$usr = new User;

// DB table to use
$table = 'tblstaff';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'name', 'dt' => 0 ),
	array( 'db' => 'gender',  'dt' => 1 ),
	array( 'db' => 'function',   'dt' => 2 ),
	array( 'db' => 'phone',     'dt' => 3 ),
	array( 'db' => 'email',     'dt' => 4 ),
	array( 'db' => 'status',     'dt' => 5,),
    array( 'db' => 'start',     'dt' => 6 ),
    array( 'db' => 'end',     'dt' => 7 ),
    array( 'db' => 'address',     'dt' => 8 )
);

if(!$usr->hasPermission('user') && !$usr->hasPermission('editor')){
    array_push($columns, array(
        'db'        => 'id',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
            return '<a href="#" class="btn btn-default btn-sm"  data-toggle="modal" data-target="#form_data" onclick="edit('. $d .');"><span class="fa fa-edit"></span></a> <a href="#" id="trow_'.$d.'" class="btn btn-danger btn-sm" onclick="deleteARow('. $d .');"><span class="fa fa-times"></span></a>';
        }
    ));
}elseif(!$usr->hasPermission('user')){
    array_push($columns, array(
        'db'        => 'id',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
            return '<a href="#" class="btn btn-default btn-sm"  data-toggle="modal" data-target="#form_data" onclick="edit('. $d .');"><span class="fa fa-edit"></span></a>';
        }
    ));
}

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


