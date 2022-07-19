<?php
	define('USER_TYPES', array(
		'admin' => '0',
		'user' => '1'
	));

	if(env('DB_USERNAME') == 'root')
	{
		define('IMAGE_URL', 'http://127.0.0.1:8000/');
	}else{
		define('IMAGE_URL', 'http://dev.arfideveloper.com/mhm/public/');
	}
?>