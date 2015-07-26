<?php
require_once '../dao/UserReviewDataDAO.php';
class UserReviewData
{
    private $serviceName;
    private $ratingNumber;
    private $comment;
   
    
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
    
    
    
    public function mapIncomingParams($serviceName,$ratingNumber,$comment) {
        $this->setServiceName($serviceName);
        $this->setRatingNumber($ratingNumber);
        $this->setComment($comment);
        
    }
    
    public function saveReview(){
        $userSaveReviewDataDAO = new UserReviewDataDAO();
        $returnSuccessMessage = $userSaveReviewDataDAO->save($this);
        return $returnSuccessMessage;
    }
    
    public function deleteLocationEntry($mobileno) {
        $currentLocationDataDAO = new CurrentLocationDataDAO();
        $this->setMobileNo($mobileno);
        $returnDeleteMessage = $currentLocationDataDAO->delete($this);
        return $returnDeleteMessage;
    }
}          
?>