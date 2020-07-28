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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
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
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['settings'] = "adviser/settings";

$route['heap-clients'] = "client/listHeapClients";
$route['register-client'] = "client/registerClient";
$route['heap-update-client/(:any)'] = 'client/heapUpdateClient/$1';
$route['heap-coupons'] = "coupon/listCoupons";
$route['add-coupon'] = "coupon/addCoupon";
$route['update-coupon/(:any)'] = 'coupon/update/$1';
$route['heap-landing-page'] = "client/heapLandingPage";
// $route['Custom-Landing-Setting'] = "client/heapThankyouPageSetting";
$route['custom-landing-setting'] = "client/customLandingSetting";
$route['heap-email-setting'] = "client/heapEmailSetting";

$route['list-reports/(:any)'] = 'report/listReports/$1';
$route['create-report/(:any)/(:any)'] = 'report/createReport/$1/$2';
$route['view-report/(:any)/(:any)'] = 'report/viewReport/$1/$2';
$route['view-report/(:any)/(:any)/(:any)'] = 'report/viewReport/$1/$2/$3';
$route['download-report/(:any)/(:any)'] = 'report/downloadReport/$1/$2';
$route['download-report/(:any)/(:any)/(:any)'] = 'report/downloadReport/$1/$2/$3';

$route['efp-clients'] = "client/listEFPClients";
$route['efp-update-client/(:any)'] = "client/efpUpdateClient/$1";
$route['education-for-protection-landing-page'] = "client/efpLandingPage";
$route['education-for-protection-email-setting'] = "client/efpEmailSetting";
$route['validation-setting'] = "client/efpValidationSetting";
$route['forewords'] = "client/efpListForewords";
$route['update-foreword/(:any)'] = "client/updateForeword/$1";
$route['default-foreword/(:any)'] = "client/showDefaultForeword/$1";

$route['retirement-kit-clients'] = "client/rkListClients";
$route['retirement-kit-update-client/(:any)'] = "client/rkUpdateClient/$1";
$route['retirement-kit-landing-page'] = "client/rkLandingPage";
$route['retirement-kit-email-setting'] = "client/rkEmailSetting";
