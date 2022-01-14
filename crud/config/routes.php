<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	$route['crud_form'] 						= "crud/crud_controller";
	$route['get_crud'] 							= "crud/crud_controller/ajax_list";
	$route['crud_add'] 							= "crud/crud_controller/add";
	$route['crud_edit/(:any)'] 							= "crud/crud_controller/edit/$1";
	$route['crud_status'] 							= "crud/crud_controller/change";
	$route['unique_mobile'] 				= "crud/crud_controller/check_unique_mobile";
	$route['unique_email'] 				= "crud/crud_controller/check_unique_email";
	