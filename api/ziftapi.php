<?php
require_once '../model/CurrentLocationData.php';
require_once '../model/NearestDriverData.php';
require_once '../model/UserReviewData.php';
require_once '../model/UserFeedbackData.php';
require_once '../model/PartyHardDriverData.php';
require_once '../model/DealsData.php';
require_once '../model/CarLoadData.php';


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

function ConvertStringEntityToUnicode($string) {
    $removeApostropheString = str_replace("'", "&#39;", $string);
    $removeBackSlashString = str_replace("\\", "&#92;", $removeApostropheString);
    $removeUnderscoreString = str_replace("_", "&#95;", $removeBackSlashString);
    return $removeUnderscoreString;
}

// --- Step 3: Process Request

// Switch based on incoming method

if (isset($_POST['method'])) {

    if (strcasecmp($_POST['method'], 'forhire') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $location = new CurrentLocationData();
        $mobileno = $_POST['mobileno'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $area = ConvertStringEntityToUnicode($_POST['area']);
        $location->mapIncomingLocationParams($mobileno, $latitude, $longitude, $area);
        $response['forHireData'] = $location -> locationData();
        deliver_response($_POST['format'], $response, true);
    }
    if (strcasecmp($_POST['method'], 'hired') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $delete = new CurrentLocationData();
        $mobileno = $_POST['mobileno'];
        $response['deleteEntry'] = $delete -> deleteLocationEntry($mobileno);
        deliver_response($_POST['format'], $response, false);
    }
    if (strcasecmp($_POST['method'], 'userReview') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $review = new UserReviewData();
        $serviceName = $_POST['serviceName'];
        $ratingNumber = $_POST['ratingNumber'];
        $comment = ConvertStringEntityToUnicode($_POST['comment']);   
        $review->mapIncomingReviewParams($serviceName, $ratingNumber, $comment);
        $response['reviewdata'] = $review -> saveReview();
        deliver_response($_POST['format'], $response, true);
    }
    if (strcasecmp($_POST['method'], 'userFeedback') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objFeedback = new UserFeedbackData();
        $mobileno = $_POST['mobileno'];
        $email = $_POST['email'];
        $feedback = ConvertStringEntityToUnicode($_POST['feedback']);
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
        $serviceName = ConvertStringEntityToUnicode($_POST['serviceName']);
        $mobileno = $_POST['mobileno'];
        $city = ConvertStringEntityToUnicode($_POST['city']);
        $isVerify = $_POST['isVerify'];
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
        $companyName = ConvertStringEntityToUnicode($_POST['companyName']);
        $offer = ConvertStringEntityToUnicode($_POST['offer']);
        $offerCode = stripslashes($_POST['offerCode']);
        $validUptoDate = stripslashes($_POST['validUptoDate']);
        $offerTerms = ConvertStringEntityToUnicode($_POST['offerTerms']);
        $isVerify = stripslashes($_POST['isVerify']);
        if(isset($_FILES['logo'])){
            $logo_tmp = $_FILES['logo']['tmp_name'];
            $logo_name = $_FILES['logo']['name'];
            $imgtype = $_FILES['logo']['type'];
            $ext = GetImageExtension($imgtype);
            $logo_changed_name = date("d-m-Y")."-".time().$ext;
            $target_path = "../deals_images/".$logo_changed_name;
        }
        $objDeals->mapIncomingDealsParams($logo_tmp, $target_path, $companyName, $offer, $offerCode, $validUptoDate, $offerTerms, $isVerify);
        $response['responseDeals'] = $objDeals -> saveDealsDetails();
        deliver_response($_POST['format'], $response, true);
    }
    if (strcasecmp($_POST['method'], 'deletePHD') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $callFunctionDeletePHD = new PartyHardDriverData();
        $mobileno = $_POST['mobileno'];
        $imageName = $_POST['imageName'];
        $response['deleteResponsePHD'] = $callFunctionDeletePHD -> deletePartyHardDriverRow($mobileno, $imageName);
        deliver_response($_POST['format'], $response, false);
    }
    if (strcasecmp($_POST['method'], 'deleteDeals') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $callFunctionDeleteDeals = new DealsData();
        $offerCode = $_POST['offerCode'];
        $imageName = $_POST['imageName'];
        $response['deleteResponseDeals'] = $callFunctionDeleteDeals -> deleteDealsRow($offerCode, $imageName);
        deliver_response($_POST['format'], $response, false);
    }
    if (strcasecmp($_POST['method'], 'verifyPHD') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $callFunctionVerifyPHD = new PartyHardDriverData();
        $mobileno = $_POST['mobileno'];
        $isVerify = $_POST['isVerify'];
        $response['verifyResponsePHD'] = $callFunctionVerifyPHD -> verifiedPartyHardDriverRow($mobileno, $isVerify);
        deliver_response($_POST['format'], $response, false);
    }
    if (strcasecmp($_POST['method'], 'verifyDeals') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $callFunctionVerifyDeals = new DealsData();
        $offerCode = $_POST['offerCode'];
        $isVerify = $_POST['isVerify'];
        $response['verifyResponseDeals'] = $callFunctionVerifyDeals -> verifiedDealsRow($offerCode, $isVerify);
        deliver_response($_POST['format'], $response, false);
    }
    if(strcasecmp($_POST['method'],'selfdrivecar')==0){
        $response['code']=1;
        $response['status']=$api_response_code[$response['code']]['HTTP Response'];
        $objSelfdrivecar=new CarLoadData();
        $carMake = $_POST['carMake'];
        $response['responseSelfdrivecar']=$objSelfdrivecar->saveSelfdrivecarDetails($carMake);
        deliver_response($_POST['format'],$response,true);
    }
    if(strcasecmp($_POST['method'],'serviceprovider')==0){
        $response['code']=1;
        $response['status']=$api_response_code[$response['code']]['HTTP Response'];
        $objServiceProviderCar=new CarLoadData();
        $logo_tmp = "";
        $target_path = "";
        $serviceProviderName = $_POST['serviceProviderName'];
        $serviceProviderType = $_POST['serviceProviderType'];
        $serviceByHourly = $_POST['serviceByHourly'];
        if(isset($_FILES['logo'])){
            $logo_tmp = $_FILES['logo']['tmp_name'];
            $logo_name = $_FILES['logo']['name'];
            $imgtype = $_FILES['logo']['type'];
            $target_path = "../service_provider_images/".$logo_name;
        }
        $objServiceProviderCar->mapIncomingServiceProviderParams($logo_tmp, $target_path, $serviceProviderName, $serviceProviderType, $serviceByHourly);
        $response['responseServiceProvider']=$objServiceProviderCar->saveServiceProvider();
        deliver_response($_POST['format'],$response,true);
    }
    if (strcasecmp($_POST['method'], 'deleteServiceProvider') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $callFunctionDeleteServiceProvider = new CarLoadData();
        $serviceProviderName = $_POST['serviceProviderName'];
        $imageName = $_POST['imageName'];
        $response['deleteResponsePHD'] = $callFunctionDeleteServiceProvider -> deleteServiceProviderByServiceProviderName($serviceProviderName, $imageName);
        deliver_response($_POST['format'], $response, false);
    }
    
}
else if (isset($_GET['method'])) {
    if(strcasecmp($_GET['method'], 'nearme') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $nearDrivers = new NearestDriverData();
        $userLatitude = $_GET['userLatitude'];
        $userLongitude = $_GET['userLongitude'];
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
    if(strcasecmp($_GET['method'],'loadCars')==0){
        $response['code']=1;
        $response['status']=$api_response_code[$response['code']]['HTTP Response'];
        $fetchCars=new CarLoadData();
        $selectedTypeOfCar=$_GET['selectedTypeOfCar'];
		$selectedCity=$_GET['selectedCity'];
        $response['loadCarsList']=$fetchCars -> loadCarsDetails($selectedTypeOfCar,$selectedCity);
        deliver_response($_GET['format'],$response,false);
    }
    if (strcasecmp($_GET['method'], 'showServiceProvider') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchServiceProvider = new CarLoadData();
        $response['showServiceProviderList'] = $fetchServiceProvider -> showServiceProvider();
        deliver_response($_GET['format'], $response, false);
    }
	if (strcasecmp($_GET['method'],'loadCity')==0){
		$response['code']=1;
		$response['status']=$api_response_code[$response['code']]['HTTP Response'];
		$fetchCity=new CarLoadData();
		$response['loadCityList']=$fetchCity -> loadCity();
		deliver_response($_GET['format'], $response,false);
	}
}
?>