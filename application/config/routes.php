<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard';
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';

// Employee Management routes
$route['employees'] = 'employees/index';
$route['employees/add'] = 'employees/add';
$route['employees/edit/(:num)'] = 'employees/edit/$1';
$route['employees/view/(:num)'] = 'employees/view/$1';
$route['employees/delete/(:num)'] = 'employees/delete/$1';
$route['employees/block/(:num)'] = 'employees/block/$1';
$route['employees/unblock/(:num)'] = 'employees/unblock/$1';
$route['employees/vacation/(:num)'] = 'employees/vacation/$1';
$route['employees/end_vacation/(:num)'] = 'employees/end_vacation/$1';

// Reports routes
$route['reports'] = 'reports/index';
$route['reports/alarms'] = 'reports/alarms';
$route['reports/tickets'] = 'reports/tickets';

// Employee Portal routes
$route['employee_portal'] = 'employee_portal/index';
$route['employee_portal/profile'] = 'employee_portal/profile';
$route['employee_portal/update_profile'] = 'employee_portal/update_profile';
$route['employee_portal/capture_photo'] = 'employee_portal/capture_photo';
$route['employee_portal/save_photo'] = 'employee_portal/save_photo';
$route['employee_portal/logout'] = 'employee_portal/logout';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
