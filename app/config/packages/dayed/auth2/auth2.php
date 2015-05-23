<?php

return array(

	// example
	'user'	=>	array(
		'driver' 	=> 'eloquent',
		'model' 	=> 'User',
		'table' 	=> 'admins',
		'view' 		=> 'emails.auth.reminder'
	),

    // example
    'member' =>  array(
        'driver'    => 'eloquent',
        'model'     => 'Admin',
        'table'     => 'admins',
        'view'      => 'emails.auth.reminder'
    ),

);
