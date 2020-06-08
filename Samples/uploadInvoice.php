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
 * Submit Feed Sample
 */

include_once ('.config.inc.php');


/************************************************************************
 * Setup
 *
 * Uncomment to configure the client instance. Configuration settings
 * are:
 *
 * - MWS endpoint URL
 * - Proxy host and port.
 * - MaxErrorRetry.
 ***********************************************************************/
// IMPORTANT: Uncomment the approiate line for the country you wish to
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


$link_to_pdf_file="/test/test.pdf";
$marketplaceIdArray = array("Id" => array('A1PA6795XXXXXX'));
$orderId = '';
$invoiceNumber = '';

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


$feed = file_get_contents($link_to_pdf_file);


$feedHandle = @fopen('php://temp', 'rw+');
fwrite($feedHandle, $feed);
rewind($feedHandle);
$parameters = array (
    'Merchant' => MERCHANT_ID,
    'MarketplaceIdList' => $marketplaceIdArray,
    'FeedType' => '_UPLOAD_VAT_INVOICE_',
    'FeedContent' => $feedHandle,
    'FeedOptions' => 'metadata:orderid='.$orderId.';metadata:invoicenumber='.$invoiceNumber.';metadata:documenttype=Invoice;metadata:transfer-encoding:chunked;data:application/pdf;base64',
    'PurgeAndReplace' => true,
    'ContentMd5' => base64_encode(md5(stream_get_contents($feedHandle), true)),
    'MWSAuthToken' => '<MWS Auth Token>', // Optional
);

rewind($feedHandle);

$request = new MarketplaceWebService_Model_SubmitFeedRequest($parameters);

invokeSubmitFeed($service, $request);

@fclose($feedHandle);

/**
 * Submit Feed Action Sample
 * Uploads a file for processing together with the necessary
 * metadata to process the file, such as which type of feed it is.
 * PurgeAndReplace if true means that your existing e.g. inventory is
 * wiped out and replace with the contents of this feed - use with
 * caution (the default is false).
 *
 * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
 * @param mixed $request MarketplaceWebService_Model_SubmitFeed or array of parameters
 */
function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request)
{
    try {
        $response = $service->submitFeed($request);

        echo ("Service Response\n");
        echo ("=============================================================================\n");

        echo("        SubmitFeedResponse\n");
        if ($response->isSetSubmitFeedResult()) {
            echo("            SubmitFeedResult\n");
            $submitFeedResult = $response->getSubmitFeedResult();
            if ($submitFeedResult->isSetFeedSubmissionInfo()) {
                echo("                FeedSubmissionInfo\n");
                $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
                if ($feedSubmissionInfo->isSetFeedSubmissionId())
                {
                    echo("                    FeedSubmissionId\n");
                    echo("                        " . $feedSubmissionInfo->getFeedSubmissionId() . "\n");
                }
                if ($feedSubmissionInfo->isSetFeedType())
                {
                    echo("                    FeedType\n");
                    echo("                        " . $feedSubmissionInfo->getFeedType() . "\n");
                }
                if ($feedSubmissionInfo->isSetSubmittedDate())
                {
                    echo("                    SubmittedDate\n");
                    echo("                        " . $feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
                }
                if ($feedSubmissionInfo->isSetFeedProcessingStatus())
                {
                    echo("                    FeedProcessingStatus\n");
                    echo("                        " . $feedSubmissionInfo->getFeedProcessingStatus() . "\n");
                }
                if ($feedSubmissionInfo->isSetStartedProcessingDate())
                {
                    echo("                    StartedProcessingDate\n");
                    echo("                        " . $feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT) . "\n");
                }
                if ($feedSubmissionInfo->isSetCompletedProcessingDate())
                {
                    echo("                    CompletedProcessingDate\n");
                    echo("                        " . $feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT) . "\n");
                }
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

