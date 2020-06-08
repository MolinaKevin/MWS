<?php

define ('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');

/**
 *  Required parameters
 */
$amazon_aws_access_key  = '';
$amazon_aws_secret_key  = '';
$merchant_id            = '';
$app_name               = 'Test uploader';
$version                = '1.0';
$route_files            = '/var/www/html/testInvoice';


define('AWS_ACCESS_KEY_ID', $amazon_aws_access_key);
define('AWS_SECRET_ACCESS_KEY', $amazon_aws_secret_key);
define('APPLICATION_NAME', $app_name);
define('APPLICATION_VERSION', $version);
define('MERCHANT_ID', $merchant_id);

// set_include_path(get_include_path() . PATH_SEPARATOR . '../../.');
set_include_path($route_files);

/************************************************************************
 * OPTIONAL ON SOME INSTALLATIONS
 *
 * Autoload function is reponsible for loading classes of the library on demand
 *
 * NOTE: Only one __autoload function is allowed by PHP per each PHP installation,
 * and this function may need to be replaced with individual require_once statements
 * in case where other framework that define an __autoload already loaded.
 *
 * However, since this library follow common naming convention for PHP classes it
 * may be possible to simply re-use an autoload mechanism defined by other frameworks
 * (provided library is installed in the PHP include path), and so classes may just
 * be loaded even when this function is removed
 ***********************************************************************/
function __autoload($className){
    $filePath = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $includePaths = explode(PATH_SEPARATOR, get_include_path());
    foreach($includePaths as $includePath){
        if(file_exists($includePath . DIRECTORY_SEPARATOR . $filePath)){
            require_once $filePath;
            return;
        }
    }
}




