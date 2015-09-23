<?php
require_once 'FeedbackMail.php';
class UserFeedbackData
{
	private $mobileno;
    private $email;
    private $feedback;

    public function setMobileNo($mobileno) {
        $this->mobileno = $mobileno;
    }
    
    public function getMobileNo() {
        return $this->mobileno;
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

    public function mapIncomingFeedbackParams($mobileno, $email, $feedback) {
        $this->setMobileNo($mobileno);
        $this->setEmail($email);
        $this->setFeedback($feedback);
    }

    public function sendFeedbackEmailToAdmin() {
        $emailSender = new FeedbackMail();
        $emailSender->setTo("feedback@ziftapp.com");
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