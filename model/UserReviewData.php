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

    public function mapIncomingReviewParams($serviceName,$ratingNumber,$comment) {
        $this->setServiceName($serviceName);
        $this->setRatingNumber($ratingNumber);
        $this->setComment($comment);
    }

    public function saveReview(){
        $userSaveReviewDataDAO = new UserReviewDataDAO();
        $returnReviewSuccessMessage = $userSaveReviewDataDAO->saveReview($this);
        return $returnReviewSuccessMessage;
    }
	
	public function showReview($serviceName) {
        $userShowReviewDataDAO = new UserReviewDataDAO();
        $this->setServiceName($serviceName);
        $returnShowData = $userShowReviewDataDAO->showReview($this);
        return $returnShowData;
    }
}
?>