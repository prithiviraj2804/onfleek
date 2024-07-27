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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'sessions/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['features'] = "welcome/features";
$route['about'] = "welcome/about";
$route['contact'] = "welcome/contact";
$route['login'] = "sessions/login";
$route['signup'] = "sessions/signup";
$route['forgetpsw'] = "sessions/forgetpsw";



$route['api/send_otp']['post']  = 'auth/send_otp';
$route['api/verify_otp']['post']  = 'auth/verify_otp';
$route['api/update_user_detail']['post']  = 'auth/update_user_detail';
$route['api/login']['post']  = 'auth/login';

$route['api/cars/basic']['post'] = "Usercars/basic";
$route['api/cars/create']['post'] = "Usercars/create";
$route['api/cars/update/(:num)']['post'] = "Usercars/update/$1";
$route['api/cars/list']['post'] = "Usercars/index";
$route['api/cars/list/(:num)']['post'] = "Usercars/index/$1";
$route['api/cars/remove/(:num)']['post'] = "Usercars/remove/$1";

$route['api/myaddress/list']['post'] = "Myaddress/index";
$route['api/myaddress/create']['post'] = "Myaddress/create";
$route['api/myaddress/update/(:num)']['post'] = "Myaddress/update/$1";
$route['api/myaddress/remove/(:num)']['post'] = "Myaddress/remove/$1";
$route['api/area/list']['post'] = "Myaddress/arealist";
$route['api/pincode/list']['post'] = "Myaddress/pincodelist";


$route['api/servicecategory/list/(:num)']['get'] = "Servicedetails/category/$1";
$route['api/servicepackage/list/(:num)']['get'] = "Servicedetails/packagelist/$1";
$route['api/servicepackage/offers/(:num)']['get'] = "Servicedetails/packageofferlist/$1";
// $route['api/servicepackage/offers']['post'] = "Servicedetails/offers";
$route['api/servicepackagedtl/view/(:num)/(:num)']['get'] = "Servicedetails/packageview/$1/$2";

$route['api/appointment/branch_list/(:num)']['get'] = "appointmentdetail/branchdtls/$1";
$route['api/appointment/book']['post'] = "appointmentdetail/create";
$route['api/appointment/list']['post'] = "appointmentdetail/appointmentlist";
$route['api/appointment/view']['post'] = "appointmentdetail/appointmentview";

$route['api/quotes/basic']['post'] = "Userquotes/basic";
$route['api/quotes/create']['post'] = "Userquotes/create";
$route['api/quotes/update']['post'] = "Userquotes/update";
$route['api/quotes/list']['post'] = "Userquotes/list";
$route['api/appointment/active']['post'] = "Userquotes/list_appointment";
$route['api/quotes/track']['post'] = "Userquotes/track";
$route['api/quotes/updatepickup']['post'] = "Userquotes/updatepickup";
$route['api/quotes/updatedelivery']['post'] = "Userquotes/updatedelivery";
$route['api/quotes/updatepayment']['post'] = "Userquotes/updatepayment";
$route['api/quotes/track']['post'] = "Userquotes/track";

// Crone
$route['api/crone/sendmail']['get'] = "Crone/sendmail";
$route['api/crone/sendfirebasemail']['get'] = "Crone/sendfirebasemail";
