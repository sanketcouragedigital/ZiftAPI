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
}          
?>