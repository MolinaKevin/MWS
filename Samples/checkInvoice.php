<?php
/**
 *  PHP Version 7
 *
 *  @category    Amazon
 *  @package     MarketplaceWebService
 *  @copyright   Copyright 2009 Amazon Technologies, Inc.
 *  @link        http://aws.amazon.com
 *  @license     http://aws.amazon.com/apache2.0  Apache License, Version 2.0
 *  @version     2009-01-01
 *
 * @PHP7Version Molina Kevin
 * @link https://github.com/MolinaKevin/MWS
 */
/*******************************************************************************

 *  Marketplace Web Service PHP7 Library
 *  Generated: Thu May 07 13:07:36 PDT 2009
 *
 */

/**
 * Get Feed Submission Result  Sample
 */

include_once ('.config.inc.php');


/************************************************************************
 * Setup
 *
 *
 * Uncomment to configure the client instance. Configuration settings
 * are:
 *
 * - MWS endpoint URL
 * - Proxy host and port.
 * - MaxErrorRetry.
 ***********************************************************************/
// IMPORTANT: Uncomment the appropriate line for the country you wish to
// sell in:
// United States:
//$serviceUrl = "https://mws.amazonservices.com";
// United Kingdom
//$serviceUrl = "https://mws.amazonservices.co.uk";
// Germany
$serviceUrl = "https://mws.amazonservices.de";
// France
//$serviceUrl = "https://mws.amazonservices.fr";
// Italy
//$serviceUrl = "https://mws.amazonservices.it";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn";
// Canada
//$serviceUrl = "https://mws.amazonservices.ca";
// India
//$serviceUrl = "https://mws.amazonservices.in";

$feedSubmissionId = '';


/************************************************************************
 * End Setup
 ***********************************************************************/


$config = array (
    'ServiceURL' => $serviceUrl,
    'ProxyHost' => null,
    'ProxyPort' => -1,
    'MaxErrorRetry' => 3,
);

$service = new MarketplaceWebService_Client(
    AWS_ACCESS_KEY_ID,
    AWS_SECRET_ACCESS_KEY,
    $config,
    APPLICATION_NAME,
    APPLICATION_VERSION);


$parameters = array (
    'Merchant' => MERCHANT_ID,
    'FeedSubmissionId' => $feedSubmissionId,
    'FeedSubmissionResult' => @fopen('/var/www/html/scripts/output', 'rw+'),
    'MWSAuthToken' => '<MWS Auth Token>', // Optional
);

$request = new MarketplaceWebService_Model_GetFeedSubmissionResultRequest($parameters);

invokeGetFeedSubmissionResult($service, $request);

/**
 * Get Feed Submission Result Action Sample
 * retrieves the feed processing report
 *
 * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
 * @param mixed $request MarketplaceWebService_Model_GetFeedSubmissionResult or array of parameters
 * @param mixed $row mysql or array of parameters
 */
function invokeGetFeedSubmissionResult(MarketplaceWebService_Interface $service, $request)
{
    try {
        $response = $service->getFeedSubmissionResult($request);

        var_dump($response);

        echo ("Service Response\n");
        echo ("=============================================================================\n");

        echo("        GetFeedSubmissionResultResponse\n");
        if ($response->isSetGetFeedSubmissionResultResult()) {
            $getFeedSubmissionResultResult = $response->getGetFeedSubmissionResultResult();
            echo ("            GetFeedSubmissionResult");

            if ($getFeedSubmissionResultResult->isSetContentMd5()) {
                echo ("                ContentMd5");
                echo ("                " . $getFeedSubmissionResultResult->getContentMd5() . "\n");
            }
        }
        if ($response->isSetResponseMetadata()) {
            echo("            ResponseMetadata\n");
            $responseMetadata = $response->getResponseMetadata();
            if ($responseMetadata->isSetRequestId())
            {
                echo("                RequestId\n");
                echo("                    " . $responseMetadata->getRequestId() . "\n");
            }
        }

        echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

        if (substr(file_get_contents('/var/www/html/scripts/output'), -3,1)=='1') {
            echo "Good";
        } else {
            echo "Error, check into Amazon Scratchpad";
        }
    } catch (MarketplaceWebService_Exception $ex) {
        echo("Caught Exception: " . $ex->getMessage() . "\n");
        echo("Response Status Code: " . $ex->getStatusCode() . "\n");
        echo("Error Code: " . $ex->getErrorCode() . "\n");
        echo("Error Type: " . $ex->getErrorType() . "\n");
        echo("Request ID: " . $ex->getRequestId() . "\n");
        echo("XML: " . $ex->getXML() . "\n");
        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
    }
}
?>
                              
