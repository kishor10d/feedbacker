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

$route['default_controller'] = "login";
$route['404_override'] = 'error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";

$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['login-history'] = "user/loginHistoy";
$route['login-history/(:num)'] = "user/loginHistoy/$1";
$route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";

$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";

/* End of file routes.php */
/* Location: ./application/config/routes.php */

/**
 * IMPORT ROUTE ***
 */
$route ['import'] = "import/index";
$route ['import/(:num)'] = "import/index/$1";

$route ['uploadRawData'] = "import/uploadRawData";
$route ['importExcel'] = "import/importExcel";
$route ['siteCapture'] = "import/siteCapture";
$route ['screenCapture'] = "import/screenCapture";

$route ['unassignCustomers'] = "import/unassignCustomers";
$route ['unassignCustomers/(:num)'] = "import/unassignCustomers/$1";
$route ['assignCustomers'] = "import/assignCustomers";
$route ['rawCustomerListing'] = "import/rawCustomerListing";
$route ['rawCustomerListing/(:num)'] = "import/rawCustomerListing/$1";
$route ['rawCustomer/(:num)'] = "import/rawCustomer/$1";

$route ['processedCustomerListing'] = "import/processedCustomerListing";
$route ['processedCustomerListing/(:num)'] = "import/processedCustomerListing/$1";

$route ['finalCustomerListing'] = "import/finalCustomerListing";
$route ['finalCustomerListing/(:num)'] = "import/finalCustomerListing/$1";

$route ['rawListing'] = "import/rawListing";
$route ['rawListing/(:num)'] = "import/rawListing/$1";

$route ['processedListing'] = "import/processedListing";
$route ['processedListing/(:num)'] = "import/processedListing/$1";

$route ['finalListing'] = "import/finalListing";
$route ['finalListing/(:num)'] = "import/finalListing/$1";

$route ['recordNewFollowup'] = "import/recordNewFollowup";
$route ['updateCustomerStatus'] = "import/updateCustomerStatus";
$route ['updateAlternateEmail'] = "import/updateAlternateEmail";
$route ['updateAlternatePhone'] = "import/updateAlternatePhone";
$route ['recordRequirement'] = "import/recordRequirement";
$route ['reqExportAsPDF'] = 'import/reqExportAsPDF';
$route ["emailPortfolio"] = "import/emailPortfolio";

$route ['followCustomerListing'] = "import/followCustomerListing";
$route ['followCustomerListing/(:num)'] = "import/followCustomerListing/$1";
$route ['followListing'] = "import/followListing";
$route ['followListing/(:num)'] = "import/followListing/$1";

$route ['refreshDomainData'] = "import/refreshDomainData";

$route ['getCustomerFollowupData'] = "import/getCustomerFollowupData";


/**
 * ********* CMS ROUTES **************
 */

$route ["emailTemplates"] = "cms/emailTemplates";
$route ["templateWrapper"] = "cms/templateWrapper";
$route ["templateWrapper/(:num)"] = "cms/templateWrapper/$1";
$route ["editTemplate/(:num)"] = "cms/editTemplate/$1";
$route ["updateEmailTemplate"] = "cms/updateEmailTemplate";
$route ["companyListing"] = "cms/companyListing";
$route ["companyListing/(:num)"] = "cms/companyListing/$1";
$route ["attachmentListing"] = "cms/attachmentListing";
$route ["attachmentListing/(:num)"] = "cms/attachmentListing/$1";
$route ["editAttachment/(:num)"] = "cms/editAttachment/$1";
$route ["updateAttachment"] = "cms/updateAttachment";

$route ["addAttachment"] = "cms/addAttachment";
$route ["addNewAttachment"] = "cms/addNewAttachment";

$route ["getTemplateByCompId"] = "cms/getTemplateByCompId";

/**
 * ******** SEO ROUTES ****************
*/
$route ["generateSeoReport"] = "seo/generateSeoReport";
$route ["generateSeoReport/(:any)"] = "seo/generateSeoReport/$1";

/**
 * ******** CACHING ROUTES ************
*/
$route ["deleteCache"] = "caching/deleteCache";
$route ["deleteAllCache"] = "caching/deleteAllCache";

/**
 * ******** REPORT ROUTES ************
 */
$route ["employeeReport"] = "report/employeeReport";
$route ["summaryReport"] = "report/summaryReport";
$route ["generateEmployeeReport"] = "report/generateEmployeeReport";