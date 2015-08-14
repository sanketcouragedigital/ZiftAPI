<?php
require_once '../dao/DriverDetailsDataDAO.php';
class DriverDetailsData
{
    private $name;
    private $mobileno;
    private $taxino;
    private $isVerify;
    private $oldmobileno;
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setMobileNo($mobileno) {
        $this->mobileno = $mobileno;
    }
    
    public function getMobileNo() {
        return $this->mobileno;
    }
    
    public function setTaxiNo($taxino) {
        $this->taxino = $taxino;
    }
    
    public function getTaxiNo() {
        return $this->taxino;
    }
    
    public function setIsVerify($isVerify) {
        $this->area = $isVerify;
    }
    
    public function getIsVerify() {
        return $this->area;
    }
    
    public function setOldMobileNo($oldmobileno) {
        $this->oldmobileno = $oldmobileno;
    }
    
    public function getOldMobileNo() {
        return $this->oldmobileno;
    }
    
    public function mapIncomingParams($name, $mobileno, $taxino, $isVerify) {
        $this->setName($name);
        $this->setMobileNo($mobileno);
        $this->setTaxiNo($taxino);
        $this->setIsVerify($isVerify);
    }
    
    public function registerDriverDetails(){
        $driverRegisterDataDAO = new DriverDetailsDataDAO();
        $returnRegisterMessage = $driverRegisterDataDAO->register($this);
        return $returnRegisterMessage;
    }
    
    public function updateDriverDetails($oldmobileno, $newmobileno, $newtaxino) {
        $driverUpdateDataDAO = new DriverDetailsDataDAO();
        $this->setOldMobileNo($oldmobileno);
        $this->setMobileNo($newmobileno);
        $this->setTaxiNo($newtaxino);
        $returnUpdateMessage = $driverUpdateDataDAO->check($this);
        return $returnUpdateMessage;
    }
}          
?>