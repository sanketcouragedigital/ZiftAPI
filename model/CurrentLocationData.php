<?php
require_once '../dao/CurrentLocationDataDAO.php';
require_once 'FeedbackMail.php';
class CurrentLocationData
{
    private $mobileno;
    private $latitude;
    private $longitude;
    private $area;
    private $serviceName;
    private $ratingNumber;
    private $comment;
    private $email;
    private $feedback;
    private $logo_tmp;
    private $target_path;
    private $city;
    private $isVerify;
    private $companyName;
    private $offer;
    private $offerCode;
    private $validUptoDate;
    private $offerTerms;
    
    public function setMobileNo($mobileno) {
        $this->mobileno = $mobileno;
    }
    
    public function getMobileNo() {
        return $this->mobileno;
    }
    
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }
    
    public function getLatitude() {
        return $this->latitude;
    }
    
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }
    
    public function getLongitude() {
        return $this->longitude;
    }
    
    public function setArea($area) {
        $this->area = $area;
    }
    
    public function getArea() {
        return $this->area;
    }
    
    public function setServiceName($serviceName) {
        $this->serviceName = $serviceName;
    }
    
    public function getServiceName() {
        return $this->serviceName;
    }
    
    public function setRatingNumber($ratingNumber) {
        $this->ratingNumber = $ratingNumber;
    }
    
    public function getRatingNumber() {
        return $this->ratingNumber;
    }
    
    public function setComment($comment) {
        $this->comment = $comment;
    }
    
    public function getComment() {
        return $this->comment;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function setFeedback($feedback) {
        $this->feedback = $feedback;
    }
    
    public function getFeedback() {
        return $this->feedback;
    }
    
    public function setLogoTemporaryName($logo_tmp) {
        $this->logo_tmp = $logo_tmp;
    }
    
    public function getLogoTemporaryName() {
        return $this->logo_tmp;
    }
    
    public function setTargetPathOfImage($target_path) {
        $this->target_path = $target_path;
    }
    
    public function getTargetPathOfImage() {
        return $this->target_path;
    }
    
    public function setCity($city) {
        $this->city = $city;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function setIsVerify($isVerify) {
        $this->isVerify = $isVerify;
    }
    
    public function getIsVerify() {
        return $this->isVerify;
    }
    
    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
    }
    
    public function getCompanyName() {
        return $this->companyName;
    }
    
    public function setOffer($offer) {
        $this->offer = $offer;
    }
    
    public function getOffer() {
        return $this->offer;
    }
    
    public function setOfferCode($offerCode) {
        $this->offerCode = $offerCode;
    }
    
    public function getOfferCode() {
        return $this->offerCode;
    }
    
    public function setValidUptoDate($validUptoDate) {
        $this->validUptoDate = $validUptoDate;
    }
    
    public function getValidUptoDate() {
        return $this->validUptoDate;
    }
    
    public function setOfferTerms($offerTerms) {
        $this->offerTerms = $offerTerms;
    }
    
    public function getOfferTerms() {
        return $this->offerTerms;
    }
    
    public function mapIncomingParams($mobileno,$latitude,$longitude,$area) {
        $this->setMobileNo($mobileno);
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->setArea($area);
    }
    
    public function mapIncomingReviewParams($serviceName,$ratingNumber,$comment) {
        $this->setServiceName($serviceName);
        $this->setRatingNumber($ratingNumber);
        $this->setComment($comment);
    }
    
    public function mapIncomingFeedbackParams($mobileno, $email, $feedback) {
        $this->setMobileNo($mobileno);
        $this->setEmail($email);
        $this->setFeedback($feedback);
    }
    
    public function mapIncomingPHDParams($logo_tmp, $target_path, $serviceName, $mobileno, $city, $isVerify) {
        $this->setLogoTemporaryName($logo_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setServiceName($serviceName);
        $this->setMobileNo($mobileno);
        $this->setCity($city);
        $this->setIsVerify($isVerify);
    }
    
    public function mapIncomingDealsParams($logo_tmp, $target_path, $companyName, $offer, $offerCode, $validUptoDate, $offerTerms) {
        $this->setLogoTemporaryName($logo_tmp);
        $this->setTargetPathOfImage($target_path);
        $this->setCompanyName($companyName);
        $this->setOffer($offer);
        $this->setOfferCode($offerCode);
        $this->setValidUptoDate($validUptoDate);
        $this->setOfferTerms($offerTerms);
    }
    
    public function locationData(){
        $currentLocationDataDAO = new CurrentLocationDataDAO();
        $returnSuccessMessage = $currentLocationDataDAO->check($this);
        return $returnSuccessMessage;
    }
    
    public function deleteLocationEntry($mobileno) {
        $currentLocationDeleteDataDAO = new CurrentLocationDataDAO();
        $this->setMobileNo($mobileno);
        $returnDeleteMessage = $currentLocationDeleteDataDAO->delete($this);
        return $returnDeleteMessage;
    }
    
    public function findNearestDrivers($userLatitude, $userLongitude) {
        $nearestDriverLocationDataDAO = new CurrentLocationDataDAO();
        $this->setLatitude($userLatitude);
        $this->setLongitude($userLongitude);
        $returnNearestDriversData = $nearestDriverLocationDataDAO->find($this);
        return $returnNearestDriversData;
    }
    
    public function saveReview(){
        $userSaveReviewDataDAO = new CurrentLocationDataDAO();
        $returnReviewSuccessMessage = $userSaveReviewDataDAO->saveReview($this);
        return $returnReviewSuccessMessage;
    }
    
    public function showReview($serviceName) {
        $userShowReviewDataDAO = new CurrentLocationDataDAO();
        $this->setServiceName($serviceName);
        $returnShowData = $userShowReviewDataDAO->showReview($this);
        return $returnShowData;
    }
    
    public function sendFeedbackEmailToAdmin() {
        $emailSender = new FeedbackMail();
        $emailSender->setTo("sanketdhotre@couragedigital.com");
        $emailSender->setFrom($this->email);
        $emailSender->setMessage($this->createEmailMessageBodyForFeedback());
        $emailSender->setSubject("An Email from ".$this->mobileno.".");
        return $emailSender->sendEmail($emailSender);
    }
    
    public function createEmailMessageBodyForFeedback() {
        $emailMessage = "Mobile No.: ".$this->mobileno."\n";
        $emailMessage.= "Email: ".$this->email."\n";
        $emailMessage.= "Feedback: ".$this->feedback;
        return $emailMessage;
    }
    
    public function savePHDDetails() {
        $PHDDetailsDAO = new CurrentLocationDataDAO();
        $returnPHDSuccessMessage = $PHDDetailsDAO->savePHD($this);
        return $returnPHDSuccessMessage;
    }
    
    public function saveDealsDetails() {
        $DealsDetailsDAO = new CurrentLocationDataDAO();
        $returnDealsSuccessMessage = $DealsDetailsDAO->saveDeals($this);
        return $returnDealsSuccessMessage;
    }
    
    public function showPHDDetails() {
        $showPHDDataDAO = new CurrentLocationDataDAO();
        $returnShowPHDDetails = $showPHDDataDAO->showPHD($this);
        return $returnShowPHDDetails;
    }
    
    public function showDealsDetails() {
        $showDealsDataDAO = new CurrentLocationDataDAO();
        $returnShowDealsDetails = $showDealsDataDAO->showDeals($this);
        return $returnShowDealsDetails;
    }
}          
?>