<?php
require_once '../model/CurrentLocationData.php';
require_once '../model/NearestDriverData.php';
require_once '../model/UserReviewData.php';
require_once '../model/UserFeedbackData.php';
require_once '../model/PartyHardDriverData.php';
require_once '../model/DealsData.php';

function deliver_response($format, $api_response, $isSaveQuery) {

    // Define HTTP responses
    $http_response_code = array(200 => 'OK', 400 => 'Bad Request', 401 => 'Unauthorized', 403 => 'Forbidden', 404 => 'Not Found');

    // Set HTTP Response
    header('HTTP/1.1 ' . $api_response['status'] . ' ' . $http_response_code[$api_response['status']]);

    // Process different content types
    if (strcasecmp($format, 'json') == 0) {

        // Set HTTP Response Content Type
        header('Content-Type: application/json; charset=utf-8');

        // Format data into a JSON response
        $json_response = json_encode($api_response);
        
        // Deliver formatted data
        echo $json_response;

    } elseif (strcasecmp($format, 'xml') == 0) {

        // Set HTTP Response Content Type
        header('Content-Type: application/xml; charset=utf-8');

        // Format data into an XML response (This is only good at handling string data, not arrays)
        $xml_response = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<response>' . "\n" . "\t" . '<code>' . $api_response['code'] . '</code>' . "\n" . "\t" . '<data>' . $api_response['data'] . '</data>' . "\n" . '</response>';

        // Deliver formatted data
        echo $xml_response;

    } else {

        // Set HTTP Response Content Type (This is only good at handling string data, not arrays)
        header('Content-Type: text/html; charset=utf-8');

        // Deliver formatted data
        echo $api_response['data'];

    }

    // End script process
    exit ;

}

// Define whether an HTTPS connection is required
$HTTPS_required = FALSE;

// Define whether user authentication is required
$authentication_required = FALSE;

// Define API response codes and their related HTTP response
$api_response_code = array(0 => array('HTTP Response' => 400, 'Message' => 'Unknown Error'), 1 => array('HTTP Response' => 200, 'Message' => 'Success'), 2 => array('HTTP Response' => 403, 'Message' => 'HTTPS Required'), 3 => array('HTTP Response' => 401, 'Message' => 'Authentication Required'), 4 => array('HTTP Response' => 401, 'Message' => 'Authentication Failed'), 5 => array('HTTP Response' => 404, 'Message' => 'Invalid Request'), 6 => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format'));

// Set default HTTP response of 'ok'
$response['code'] = 0;
$response['status'] = 404;

// --- Step 2: Authorization

// Optionally require connections to be made via HTTPS
if ($HTTPS_required && $_SERVER['HTTPS'] != 'on') {
    $response['code'] = 2;
    $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
    $response['data'] = $api_response_code[$response['code']]['Message'];

    // Return Response to browser. This will exit the script.
    deliver_response($_GET['format'], $response);
}

// Optionally require user authentication
if ($authentication_required) {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $response['code'] = 3;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $response['data'] = $api_response_code[$response['code']]['Message'];

        // Return Response to browser
        deliver_response($_GET['format'], $response);

    }

    // Return an error response if user fails authentication. This is a very simplistic example
    // that should be modified for security in a production environment
    elseif ($_POST['username'] != 'foo' && $_POST['password'] != 'bar') {
        $response['code'] = 4;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $response['data'] = $api_response_code[$response['code']]['Message'];

        // Return Response to browser
        deliver_response($_GET['format'], $response);

    }

}
// Get Image Extension og logo.
function GetImageExtension($imagetype) {
    if(empty($imagetype)) return false;
    switch($imagetype)
    {
        case 'image/bmp': return '.bmp';
        case 'image/gif': return '.gif';
        case 'image/jpeg': return '.jpeg';
        case 'image/jpg': return '.jpg';
        case 'image/png': return '.png';
        default: return false;
    }
}

// --- Step 3: Process Request

// Switch based on incoming method

if (isset($_POST['method'])) {

    if (strcasecmp($_POST['method'], 'forhire') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $location = new CurrentLocationData();
        $mobileno = stripslashes($_POST['mobileno']);
        $latitude = stripslashes($_POST['latitude']);
        $longitude = stripslashes($_POST['longitude']);
        $area = stripslashes($_POST['area']);
        $location->mapIncomingLocationParams($mobileno, $latitude, $longitude, $area);
        $response['forHireData'] = $location -> locationData();
        deliver_response($_POST['format'], $response, true);
    }
    if (strcasecmp($_POST['method'], 'hired') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $delete = new CurrentLocationData();
        $mobileno = stripslashes($_POST['mobileno']);
        $response['deleteEntry'] = $delete -> deleteLocationEntry($mobileno);
        deliver_response($_POST['format'], $response, false);
    }
    if (strcasecmp($_POST['method'], 'userReview') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $review = new UserReviewData();
        $serviceName = stripslashes($_POST['serviceName']);
        $ratingNumber = stripslashes($_POST['ratingNumber']);
        $comment = stripslashes($_POST['comment']);     
        $review->mapIncomingReviewParams($serviceName, $ratingNumber, $comment);
        $response['reviewdata'] = $review -> saveReview();
        deliver_response($_POST['format'], $response, true);
    }
    if (strcasecmp($_POST['method'], 'userFeedback') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objFeedback = new UserFeedbackData();
        $mobileno = stripslashes($_POST['mobileno']);
        $email = stripslashes($_POST['email']);
        $feedback = stripslashes($_POST['feedback']);
        $objFeedback->mapIncomingFeedbackParams($mobileno, $email, $feedback);
        $response['mailFeedback'] = $objFeedback -> sendFeedbackEmailToAdmin();
        deliver_response($_POST['format'], $response, true);
    }
    if (strcasecmp($_POST['method'], 'phd') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objPHD = new PartyHardDriverData();
        $logo_tmp = "";
        $target_path = "";
        $serviceName = stripslashes($_POST['serviceName']);
        $mobileno = stripslashes($_POST['mobileno']);
        $city = stripslashes($_POST['city']);
        $isVerify = stripslashes($_POST['isVerify']);
        if(isset($_FILES['logo'])){
            $logo_tmp = $_FILES['logo']['tmp_name'];
            $logo_name = $_FILES['logo']['name'];
            $imgtype = $_FILES['logo']['type'];
            $ext = GetImageExtension($imgtype);
            $logo_changed_name = date("d-m-Y")."-".time().$ext;
            $target_path = "../phd_images/".$logo_changed_name;
        }
        $objPHD->mapIncomingPHDParams($logo_tmp, $target_path, $serviceName, $mobileno, $city, $isVerify);
        $response['responsePHD'] = $objPHD -> savePHDDetails();
        deliver_response($_POST['format'], $response, true);
    }
    if (strcasecmp($_POST['method'], 'deals') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objDeals = new DealsData();
        $logo_tmp = "";
        $target_path = "";
        $companyName = stripslashes($_POST['companyName']);
        $offer = stripslashes($_POST['offer']);
        $offerCode = stripslashes($_POST['offerCode']);
        $validUptoDate = stripslashes($_POST['validUptoDate']);
        $offerTerms = stripslashes($_POST['offerTerms']);
        if(isset($_FILES['logo'])){
            $logo_tmp = $_FILES['logo']['tmp_name'];
            $logo_name = $_FILES['logo']['name'];
            $imgtype = $_FILES['logo']['type'];
            $ext = GetImageExtension($imgtype);
            $logo_changed_name = date("d-m-Y")."-".time().$ext;
            $target_path = "../deals_images/".$logo_changed_name;
        }
        $objDeals->mapIncomingDealsParams($logo_tmp, $target_path, $companyName, $offer, $offerCode, $validUptoDate, $offerTerms);
        $response['responseDeals'] = $objDeals -> saveDealsDetails();
        deliver_response($_POST['format'], $response, true);
    }
}
else if (isset($_GET['method'])) {
    if(strcasecmp($_GET['method'], 'nearme') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $nearDrivers = new NearestDriverData();
        $userLatitude = stripslashes($_GET['userLatitude']);
        $userLongitude = stripslashes($_GET['userLongitude']);
        $response['nearestDrivers'] = $nearDrivers->findNearestDrivers($userLatitude, $userLongitude);
        deliver_response($_GET['format'], $response, false);
    }
    if (strcasecmp($_GET['method'], 'showReview') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetch = new UserReviewData();
        $serviceName = $_GET['serviceName'];
        $response['showReviewData'] = $fetch -> showReview($serviceName);
        deliver_response($_GET['format'], $response, false);
    }
    if (strcasecmp($_GET['method'], 'showPHD') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPHD = new PartyHardDriverData();
        $response['showPHDList'] = $fetchPHD -> showPHDDetails();
        deliver_response($_GET['format'], $response, false);
    }
    if (strcasecmp($_GET['method'], 'showDeals') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchDeals = new DealsData();
        $response['showDealsList'] = $fetchDeals -> showDealsDetails();
        deliver_response($_GET['format'], $response, false);
    }
}
?>